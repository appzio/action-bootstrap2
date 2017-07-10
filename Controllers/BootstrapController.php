<?php


namespace Bootstrap\Controllers;

use Bootstrap\Router\BootstrapRouter;

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

    public function actionDefault(){
        return ['View','viewerror'];
    }

    public function viewError(){
        return ['View','viewerror'];
    }

    public function getMenuId(){
        return $this->router->getMenuId();
    }





}