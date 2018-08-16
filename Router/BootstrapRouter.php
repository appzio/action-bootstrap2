<?php

/**
 * This class handles the routing for actions. Router will always first search for theme & mode files and
 * revert to action main level if they are missing and finally to default Controller.php, View.php & Models.php.
 * When creating actions and themes, make sure that the routes are defined correctly, any misdefined route will
 * cause an error.
 *
 * Action modes are defined in the action's web configuration (and need to be set in the form file).
 *
 * If action has permanent route active, it will use that. Permanent routes are saved into session, so if your
 * action is stuck on a wrong route, you can use the debug action to clear all session values to clear the routes also.
 * There is also a controller method for clearing action's routes called $this->flushActionRoutes();
 *
 * Class BootstrapRouter
 * @package Bootstrap\Router
 */

namespace Bootstrap\Router;

class BootstrapRouter implements BootstrapRouterInterface {

    use \Bootstrap\Router\BootstrapRouterGetters;

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
    public $phpstorm_bugfix;

    /**
     * The view instance. Views are passed the data returned from the controller and
     * are responsible for generating the layout data.
     *
     * @var \Bootstrap\Views\BootstrapView
     */
    public $view;

    /**
     * The model instance. Models are responsible for querying and storing data but
     * also provide useful utility methods for sessions, variables and validation.
     *
     * @var \Bootstrap\Models\BootstrapModel
     */
    public $model;

    /**
     * The current menu id if set
     * @var
     */
    public $menuid;

    /**
     * @var
     */
    public $new_menuid;

    /**
     * @var
     */
    public $actionid;

    /**
     * @var
     */
    public $action_id;

    /**
     * The current view name
     *
     * @var
     */
    public $view_name;

    /**
     * The current action name as defined when created.
     *
     * @var
     */
    private $action_name;

    /**
     * The currently called controller class name.
     *
     * @var
     */
    private $controller_name;

    /**
     * @var
     */
    private $error;

    /**
     * The controller instance
     *
     * @var
     */
    public $controller;

    /**
     * Layout data returned from the view after it was called with the controller data.
     * @var
     */
    private $view_data;

    /**
     * Path to the controller class
     *
     * @var
     */
    private $controller_path;

    /**
     * Path to main component instance. This class makes use of the other
     * actions in the same module and provides them to the controller under
     * the $components property
     *
     * @var
     */
    private $component_path;

    /**
     * Action shortname/permaname. Acts as a slug, usually all lowercase
     * letters with no blank spaces.
     *
     * @var
     */
    private $action_shortname;

    /**
     * BootstrapRouter constructor.
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
    }

    /**
     * Check whether controller class exists
     *
     * @param $primary
     * @param $secondary
     * @return mixed
     */
    private function checkExistence($primary,$secondary){
        if(classExists($primary)){
            $this->controller_path = $primary;
            return $primary;
        } elseif(classExists($secondary)) {
            $this->controller_path = $secondary;
            return $secondary;
        }
    }


    /**
     *  Controller routing logic:
     *   1. look for active route inside the theme
     *
     *   2. look for active route on the main level
     *
     *   3. look for mode inside the the theme
     *
     *   4. look for mode inside the main level
     *
     *   5. look for default controller inside the theme
     *
     *   6. look for default controller on the main level
     *
     * @param $class
     * @return string
     */
    public function getController($class){
        $this->setRoute();

        $mode = $this->model->getConfigParam('mode');
        $theme = $this->model->getConfigParam('article_action_theme');

        $themepath = $this->getMainPath() ."\\themes\\" .$theme .'\\Controllers\\';
        $mainpath = $this->getMainPath() .'\\Controllers\\';
        $default = $class ."Controllers\Controller";


        /* 1 & 2 active route */
        if($this->controller_name){
            /* check inside the theme */
            if(classExists($themepath.ucfirst($this->controller_name))) {
                $this->controller_path = $themepath.ucfirst($this->controller_name);
                $this->controller_name = ucfirst($this->controller_name);
                return $this->controller_path;
            }

            if(classExists($mainpath.ucfirst($this->controller_name))) {
                $this->controller_path = $mainpath.ucfirst($this->controller_name);
                $this->controller_name = ucfirst($this->controller_name);
                return $this->controller_path;
            }
        }

        /* 3 & 4 mode */
        if($mode){
            if(classExists($themepath.ucfirst($mode))) {
                $this->controller_path = $themepath.ucfirst($mode);
                $this->controller_name = ucfirst($mode);
                return $this->controller_path;
            }

            if(classExists($mainpath.ucfirst($mode))) {
                $this->controller_path = $mainpath.ucfirst($mode);
                $this->controller_name = ucfirst($mode);
                return $this->controller_path;
            }
        }

        /* 5 & 6 default */
        if(classExists($themepath.'Controller')) {
            $this->controller_path = $themepath.'Controller';
            $this->controller_name = 'Controller';
            return $this->controller_path;
        }

        if(classExists($mainpath.'Controller')) {
            $this->controller_path = $mainpath.'Controller';
            $this->controller_name = 'Controller';
            return $this->controller_path;
        }

        $this->controller_path = $default;
        $this->controller_name = 'Controller';
        $this->error[] = 'Defined controller for the route not found';
        return $default;

    }

    /**
     * Get component class path. This class provides access to the module's components.
     *
     * @param $class
     * @return string
     */
    public function getComponent($class){

        $default = $class ."Components\Components";
        $backup = $this->getMainPath() ."\Components\Components";

        if(classExists($default)){
            $this->component_path = $default;
            return $default;
        } elseif(classExists($backup)) {
            $this->component_path = $backup;
            return $backup;
        } else {
            $this->error[] = 'Defined component for the route not found';
            return $default;
        }
    }

    /**
     * Get path to the currently called action's module.
     *
     * @return string
     */
    private function getMainPath(){
        $name = 'packages\action'.ucfirst($this->action_shortname);
        return $name;
    }


    /**
     * Get path to the currently called view. View name is passed
     * from the controller returned data.
     *
     * @param $class -- class hierarchy coming from ArticleFactory
     * @return bool|string
     */

    public function getView($class){

        // look for others
        $default = $class ."Views\View";
        $defined = $class ."Views\\".ucfirst($this->view_name);
        $backup = $this->getMainPath() ."\Views\\".ucfirst($this->view_name);
        $backup2 = $this->getMainPath() .'\Views\View';

        if(classExists($defined)){
            return $defined;
        } elseif(classExists($backup)) {
            return $backup;
        } elseif(classExists($backup2)) {
            return $backup2;
        } else {
            $this->error[] = 'Defined view not found';
            return $default;
        }
    }

    /**
     * @param bool $route
     * @param bool $include_menuid
     */
    private function configureNames($route=false,$include_menuid=false){

        $parts_raw = explode('/',$route);
        $route = strtolower($route);
        $parts = explode('/',$route);

        if(isset($parts[1]) AND !empty($parts[1])){
            $this->controller_name = $parts[0];
            $this->action_name = $parts[1];
        } elseif(isset($parts[0]) AND $parts[0]) {
            $this->action_name = 'default';
        } else {
            $this->action_name = 'default';
        }

        /* note that this gets included only from request, not from session */
        if(isset($parts[2]) AND !empty($parts[2]) AND $include_menuid){
            $this->menuid = $parts_raw[2];
        }

    }

    /**
     * If current routing is marked to be persistent and is not overriden by the
     * current menu call, we will use the currently active route
     *
     * @return void
     */
    private function setRoute(){
        if(stristr($this->menuid, '/')) {
            $this->configureNames($this->menuid,true);
        }elseif($this->model->sessionGet('persist_route_'.$this->action_id)){
            $route = $this->model->sessionGet('current_route_'.$this->action_id);
            $this->configureNames($route);
        } else {
            $this->configureNames();
        }
    }
    
    /**
     * Call the controller method if it exists, else call the default one.
     * It returns the view name that should be called and data that should
     * be passed to it.
     *
     * @return void
     */
    public function prepareView(){
    	
        $name = 'action'.ucfirst($this->action_name);
        $default = 'actionDefault';

        if(method_exists($this->controller, $name)){
            $viewinfo = $this->controller->$name();
        } elseif(method_exists($this->controller, $default)) {
            $this->error[] = 'Unknown controller method '.$default .' @ controller: ' .$this->controller_name;
            $viewinfo = $this->controller->$default();
        } else {
            $this->error[] = 'No controller methods found';
            $viewinfo = $this->view->actionViewerror();
        }

	    $this->view_name = $viewinfo[0];
	    $this->view_data = ( isset($viewinfo[1]) ? $viewinfo[1] : [] );
    }

}