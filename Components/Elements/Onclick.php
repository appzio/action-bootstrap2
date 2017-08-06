<?php

namespace Bootstrap\Components\Elements;
use Bootstrap\Views\BootstrapView;
use function explode;
use function stristr;

trait Onclick {

    /**
     * @param array $parameters sync_open, sync_close, context,
     * <code>
     * $array = array(
     * 'sync_open' => '1',
     * 'sync_close'   => '1',
     * 'context' => 'someid', // anything with context will get pre-cached by the client
     * 'back_button' => '1',
     * 'id' => 'someid',
     * );
     * </code>

     * @return \stdClass
     */

    public function getOnclickTab(int $number, array $parameters=array(),array $saveids = array()) {
        /** @var BootstrapView $this */

		$obj = new \StdClass;
        $obj->action = 'open-tab';
        $obj->action_config = $number;

        $obj = $this->attachParameters($obj,$parameters);

        if($saveids){

        }

        return $obj;
	}

    public function getOnclickShowDiv(string $divid, array $parameters=array(),array $saveids = array()) {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'show-div';
        $obj->div_id = $divid;

        $obj = $this->attachParameters($obj,$parameters);

        if($saveids){

        }

        return $obj;
    }

    public function getOnclickHideDiv(string $divid, array $parameters=array(),array $saveids = array()) {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'hide-div';
        $obj->div_id = $divid;

        $obj = $this->attachParameters($obj,$parameters);

        if($saveids){

        }

        return $obj;
    }

    public function getOnclickSubmit(string $menuid,$clickparameters=array()){

        $controller = $this->router->getControllerName();
        $action = $this->router->getActionName();

        $obj = new \StdClass;
        $obj->action = 'submit-form-content';
        $obj->id = $controller.'/'.$action .'/' .$menuid;
        $obj = $this->attachParameters($obj,$clickparameters);

        return $obj;

    }

    public function getOnclickCompleteAction(){
        $obj = new \StdClass;
        $obj->action = 'complete-action';
        return $obj;
    }




    public function getOnclickRoute(string $route,$persist_route=true,array $saveparameters = array(),bool $async=true,array $clickparameters=array()) {
        /** @var BootstrapView $this */

        /* menuid will also need to be passed to session if using this function,
        as the save is a two part process */
        $menuid = false;

        /* route is always marked by slash */
        $routeparts = explode('/', $route);

        if(!isset($routeparts[1]) OR empty($routeparts[1])){
            $this->errors[] = 'Route is not defined right. It should controller/method';
        }

        $obj = new \StdClass;
        $obj->action = 'submit-form-content';
        $obj->id = $route;
        $obj = $this->attachParameters($obj,$clickparameters);

        /* if we have also parameters to save we will first call
           server to save them and only then submit the second view */

        $persist_route = $persist_route == true ? 1 : 0;

        $persist = 'persist_route_'.$this->actionid;
        $current = 'current_route_'.$this->actionid;

        $saveparameters[$persist] = $persist_route;
        $saveparameters[$current] = $route;
        $saveparameters['save_async'] = 1;
        $saveparameters['menu_id'] = $menuid;
        $identifier = md5(serialize($saveparameters).$route.$persist_route);

        /* These are marked for saving, but not actually saved to session
        yet, only if matching menuid is actually clicked, they would get
        saved by the ArticleFactory. This save is like an intent to possibly
        save to session. */

        $this->model->click_parameters_to_save[$identifier] = $saveparameters;

        $onclick = new \stdClass();
        $onclick->action = 'submit-form-content';
        $onclick->id = $identifier;

        if(!$async){
            $obj->sync_open = 1;
            $onclick->sync_open = 1;
        }

        $output[] = $onclick;
        $output[] = $obj;
        return $output;

    }

    public function getOnclickImageUpload(string $variablename,$parameters=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'upload-image';
        $obj->variable = $this->model->getVariableId($variablename);


        $obj = $this->attachParameters($obj,$parameters);

        return $obj;
    }


    /**
     * @param array $parameters
     * <code>
     * $array = array(
     * 'sync_open' => '1',
     * 'id' => 'someid',
     * );
     * </code>

     * @return \stdClass
     */
    public function getOnclickLocation($parameters=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'ask-location';
        $obj = $this->attachParameters($obj,$parameters);

        return $obj;
    }

    /**
     * @param $url // valid url (can be also tel://3391282822 for example)
     * @param array $parameters
     * <code>
     * $array = array(
     * );

     * @return \stdClass
     */
    public function getOnclickOpenUrl($url, $parameters=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'open-url';
        $obj->action_config = $url;
        $obj = $this->attachParameters($obj,$parameters);

        return $obj;
    }

    public function getOnclickOpenAction($permaname=false,$actionid=false,$parameters=array()){

        if($permaname){
            $actionid = $this->model->getActionidByPermaname($permaname);
        }

        $obj = new \stdClass();
        $obj->action = 'open-action';
        $obj->action_config = $actionid;

        $obj = $this->attachParameters($obj,$parameters);

        return $obj;

    }



}