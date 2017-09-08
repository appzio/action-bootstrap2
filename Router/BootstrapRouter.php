<?php


namespace Bootstrap\Router;

use function array_pop;
use function basename;
use Bootstrap\Views\BootstrapRouterGetters;
use function classExists;
use function Composer\Autoload\includeFile;
use function explode;
use function file_exists;
use function file_get_contents;
use function getNameSpacePath;
use function implode;
use function method_exists;
use function stristr;
use function strtolower;
use function strtoupper;
use function ucfirst;

class BootstrapRouter implements BootstrapRouterInterface {

    use \Bootstrap\Router\BootstrapRouterGetters;

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
    public $phpstorm_bugfix;

    /* @var \Bootstrap\Views\BootstrapView */
    public $view;

    /* @var \Bootstrap\Models\BootstrapModel */
    public $model;

    public $menuid;
    public $new_menuid;
    public $actionid;

    public $action_id;

    public $view_name;
    private $action_name;
    private $controller_name;
    private $error;

    public $controller;
    private $view_data;
    private $controller_path;
    private $component_path;
    private $action_shortname;

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

    private function checkExistence($primary,$secondary){
        if(classExists($primary)){
            $this->controller_path = $primary;
            return $primary;
        } elseif(classExists($secondary)) {
            $this->controller_path = $secondary;
            return $secondary;
        }
    }

    /*
        1. look for active route inside the theme
        2. look for active route on the main level
        3. look for mode inside the the theme
        4. look for mode inside the main level
        5. look for default controller inside the theme
        6. look for default controller on the main level
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
                return $this->controller_path;
            }

            if(classExists($mainpath.ucfirst($this->controller_name))) {
                $this->controller_path = $mainpath.ucfirst($this->controller_name);
                return $this->controller_path;
            }
        }

        /* 3 & 4 mode */
        if($mode){
            if(classExists($themepath.ucfirst($mode))) {
                $this->controller_path = $themepath.ucfirst($mode);
                return $this->controller_path;
            }

            if(classExists($mainpath.ucfirst($mode))) {
                $this->controller_path = $mainpath.ucfirst($mode);
                return $this->controller_path;
            }
        }

        /* 5 & 6 default */
        if(classExists($themepath.'Controller')) {
            $this->controller_path = $themepath.'Controller';
            return $this->controller_path;
        }

        if(classExists($mainpath.'Controller')) {
            $this->controller_path = $mainpath.'Controller';
            return $this->controller_path;
        }

        $this->controller_path = $default;
        $this->error[] = 'Defined controller for the route not found';
        return $default;

    }

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

    private function getMainPath(){
        $name = 'packages\action'.ucfirst($this->action_shortname);
        return $name;
    }


    /**
     * @param $class -- class hierarchy coming from ArticleFactory
     * @return bool|string
     *
     *
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


    private function configureNames($route=false,$include_menuid=false){

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
            $this->menuid = $parts[2];
        }

    }

    private function setRoute(){
        /* if current routing is marked to be persistent and is not overriden by the
        current menu call, we will use the currently active route */

        if(stristr($this->menuid, '/')) {
            $this->configureNames($this->menuid,true);
        }elseif($this->model->sessionGet('persist_route_'.$this->action_id)){
            $route = $this->model->sessionGet('current_route_'.$this->action_id);
            $this->configureNames($route);
        } else {
            $this->configureNames();
        }
    }

/*    public function customRouting($class,$original_route,$case,$default){
        $path = getNameSpacePath($class);
        $path = $path .'Router/Router.php';

        $original_route_array = explode('\\', $original_route);
        $newroute = array_pop($original_route_array);

        if(file_exists($path)){
            require_once($path);

            if(isset($routes[$newroute][$case])){
                $original_route_array[] = $routes[$newroute][$case];
                $original_route = implode('\\', $original_route_array);
                return $original_route;
            }
        }

        return $original_route;
    }*/

    public function prepareView(){

        $name = 'action'.ucfirst($this->action_name);
        $default = 'actionDefault';

        if(method_exists($this->controller, $name)){
            $viewinfo = $this->controller->$name();
            $this->view_name = $viewinfo[0];
            $this->view_data = $viewinfo[1];
        } elseif(method_exists($this->controller, $default)) {
            $this->error[] = 'Unknown controller method '.$default .' @ controller: ' .$this->controller_name;
            $viewinfo = $this->controller->$default();
            $this->view_name = $viewinfo[0];
            $this->view_data = $viewinfo[1];
        } else {
            $this->error[] = 'No controller methods found';
            $viewinfo = $this->view->actionViewerror();
            $this->view_name = $viewinfo[0];
            $this->view_data = $viewinfo[1];
        }

    }




}