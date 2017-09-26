<?php


namespace Bootstrap\Controllers;

use Bootstrap\Router\BootstrapRouter;
use stdClass;

/**
 * Class BootstrapController
 * @package Bootstrap\Controllers
 */
class BootstrapController implements BootstrapControllerInterface {

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
    public $phpstorm_bugfix;

    /* @var \Bootstrap\Views\BootstrapView */
    public $view;

    /* @var \Bootstrap\Models\BootstrapModel */
    public $model;

    /* @var BootstrapRouter */
    public $router;

    public $current_tab;
    private $view_name;

    public $action_name;

    public $playid;

    public $onloads;

    /**
     * set this to true to suppress output (for async operations)
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
     * @return mixed
     */
    public function getMenuId(){
        return $this->router->getMenuId();
    }

    /**
     * Collects location once
     * @return bool
     */
    public function collectLocation(){
        $cache = \Appcaching::getGlobalCache('location-asked'.$this->playid);

        if(!$cache){
            $menu2 = new stdClass();
            $menu2->action = 'ask-location';
            \Appcaching::setGlobalCache('location-asked'.$this->playid,true);
            $this->onloads[] = $menu2;
        } else {
            return false;
        }
    }

}