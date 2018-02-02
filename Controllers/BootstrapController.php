<?php


namespace Bootstrap\Controllers;

use Bootstrap\Router\BootstrapRouter;

/**
 * Class BootstrapController
 * @package Bootstrap\Controllers
 */
class BootstrapController implements BootstrapControllerInterface {

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
    public $phpstorm_bugfix;

    /**
     * The view instance. Views are responsible for returning the layout of the app dependining on the information passed from the controller.
     *
     * @var \Bootstrap\Views\BootstrapView
     */
    public $view;

    /**
     * The model instance. Models are used to query and save data to storage.
     * They also provide access to variable, session, validation and other utility methods.
     *
     * @var \Bootstrap\Models\BootstrapModel
     */
    public $model;

    /**
     * The router class instance. The router is responsible for instantiating the controller and the view.
     *
     * @var BootstrapRouter
     */
    public $router;

    /**
     * Current active tab
     *
     * @var
     */
    public $current_tab;

    /**
     * @var
     */
    private $view_name;

    /**
     * Active action name
     *
     * @var mixed
     */
    public $action_name;

    /**
     * Currently logged user id
     *
     * @var
     */
    public $playid;

    /**
     * Array of actions that should be triggered when the application loads.
     * These can vary but making a refresh on load can cause an infinite loop.
     *
     * @var
     */
    public $onloads;

    /**
     * Set this to true to suppress output (for async operations)
     */
    public $no_output = false;

    /**
     * BootstrapController constructor.
     * @param $obj
     */
    public function __construct($obj){
        /* this exist to make the referencing of
        passed objects & variables easier */

        while($n = each($this)){
            $key = $n['key'];
            if(isset($obj->$key) AND !$this->$key){
                $this->$key = $obj->$key;
            }
        }

        $this->action_name = $this->router->getActionName();
    }

    /**
     * Default entry point for controllers
     *
     * @return array
     */
    public function actionDefault(){
        return ['View','viewerror'];
    }

    /**
     * @return array
     */
    public function viewError(){
        return ['View','viewerror'];
    }

    /**
     * Return current menu id if set
     *
     * @return mixed
     */
    public function getMenuId(){
        return $this->router->getMenuId();
    }

    /**
     * Collects location once
     *
     * @return mixed
     */
    public function collectLocation( $timetolive = false, $return_timezone = false ){
        $cache = \Appcaching::getGlobalCache('location-asked'.$this->playid);

        if(!$cache){
            $task = new \stdClass();
	        $task->action = 'ask-location';
            \Appcaching::setGlobalCache('location-asked'.$this->playid,true, $timetolive);
            $this->onloads[] = $task;

            if ( $return_timezone ) {
				return $this->getTimezone(
					$this->model->getSavedVariable( 'lat' )	,
					$this->model->getSavedVariable( 'lon' )
				);
            }

        } else {
            return false;
        }

    }

    /* this is a special action you can call to flush routes */
    public function actionFlushroutes(){
        $this->model->flushActionRoutes();
        $this->no_output = true;
        return ['Blank',array()];
    }

    public function getTimezone($cur_lat, $cur_long, $country_code = '') {
	    $timezone_ids = ($country_code) ? \DateTimeZone::listIdentifiers(\DateTimeZone::PER_COUNTRY, $country_code)
		    : \DateTimeZone::listIdentifiers();

	    if ($timezone_ids && is_array($timezone_ids) && isset($timezone_ids[0])) {

		    $time_zone = array();
		    $tz_distance = 0;

		    if (count($timezone_ids) == 1) {
			    $time_zone = $timezone_ids[0];
		    } else {

			    foreach($timezone_ids as $timezone_id) {
				    $timezone = new \DateTimeZone($timezone_id);
				    $location = $timezone->getLocation();
				    $tz_lat = $location['latitude'];
				    $tz_long = $location['longitude'];

				    $theta = $cur_long - $tz_long;
				    $distance = (sin(deg2rad($cur_lat)) * sin(deg2rad($tz_lat)))
				                + (cos(deg2rad($cur_lat)) * cos(deg2rad($tz_lat)) * cos(deg2rad($theta)));
				    $distance = acos($distance);
				    $distance = abs(rad2deg($distance));

				    if (!$time_zone || $tz_distance > $distance) {

					    $dateTime = new \DateTime("now", $timezone);
					    $offset = $timezone->getOffset( $dateTime );

					    $time_zone = array(
						    'timezone_id' => $timezone_id,
						    'offset_in_seconds' => $offset,
					    );

					    $tz_distance = $distance;
				    }
			    }

		    }

		    return $time_zone;
	    }

	    return false;
    }

}