<?php

namespace Bootstrap\Components\ClientComponents;

use Bootstrap\Views\BootstrapView;

trait Onclick
{

    /**
     * When the component is clicked a certain tab should be opened
     *
     * @param $number int
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
     * @param $saveids array
     * @return \stdClass
     */
    public function getOnclickTab(int $number, array $parameters = array(), array $saveids = array())
    {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'open-tab';
        $obj->action_config = $number;

        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * When the component is clicked a div with the corresponding divid should be shown
     *
     * @param string $divid
     * @param array $parameters tap_to_close, transition, layout, background
     * @param array $layout
     * @param array $saveids
     * @return \stdClass
     */
    public function getOnclickShowDiv(string $divid, array $parameters = array(), $layout = array(), array $saveids = array())
    {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'show-div';
        $obj->div_id = $divid;

        if ($layout) {
            $obj->layout = new \stdClass();
            foreach ($layout as $key => $item) {
                $obj->layout->$key = $item;
            }
        }

        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }


    public function getOnclickLogout()
    {
        $obj = new \StdClass;
        $obj->action = 'logout';
        return $obj;
    }

    /**
     * When the component is clicked a div with the corresponding divid should be hidden
     *
     * @param string $divid
     * @param array $parameters
     * @param array $saveids
     * @return \stdClass
     */
    public function getOnclickHideDiv(string $divid, array $parameters = array(), array $saveids = array())
    {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'hide-div';
        $obj->div_id = $divid;

        $obj = $this->attachParameters($obj, $parameters);

        if ($saveids) {

        }

        return $obj;
    }

    /**
     * When the component is clicked an element with the given id should be hidden
     *
     * @param string $element_id
     * @param array $parameters
     * @param array $saveids
     * @return \stdClass
     */
    public function getOnclickHideElement(string $element_id, array $parameters = array(), array $saveids = array())
    {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'hide-view';
        $obj->view_id = $element_id;

        $obj = $this->attachParameters($obj, $parameters);
        return $obj;
    }

    /**
     * When the component is clicked an element with the given id should be shown
     *
     * @param string $element_id
     * @param array $parameters
     * @param array $saveids
     * @return \stdClass
     */
    public function getOnclickShowElement(string $element_id, array $parameters = array(), array $saveids = array())
    {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->action = 'show-view';
        $obj->view_id = $element_id;

        $obj = $this->attachParameters($obj, $parameters);
        return $obj;
    }


    public function getOnclickTouchId($text = '{#login_with_touch_id#}', $clickparameters = array())
    {
        $obj = new \StdClass();
        $obj->action = 'request-touchid';
        $obj->action_config = $text;
        $obj = $this->attachParameters($obj, $clickparameters);
        return $obj;

    }

    /**
     * Clicking the component to which this is attached will trigger a submit action
     *
     * @param string $menuid
     * @param array $clickparameters
     * @return \stdClass
     */
    public function getOnclickSubmit(string $menuid, $clickparameters = array())
    {

        $controller = $this->router->getControllerName();
        $action = $this->router->getActionName();

        /* in case its a route */
        if (!stristr($menuid, '/')) {
            $menuid = $controller . '/' . $action . '/' . $menuid;
        }

        $obj = new \StdClass;
        $obj->action = 'submit-form-content';
        $obj->id = $menuid;
        $obj = $this->attachParameters($obj, $clickparameters);

        return $obj;

    }

    public function getOnclickSetVariables(array $variables, $clickparameters = array())
    {
        $obj = new \StdClass;
        $obj->action = 'set-variables';
        $obj->set_variables_data = new \stdClass();

        if (empty($variables)) {
            $this->errors[] = 'You are using set variables onclick, but no variables are defined';
        }

        foreach ($variables as $var => $value) {
            $obj->set_variables_data->$var = $value;
        }


        $obj = $this->attachParameters($obj, $clickparameters);
        return $obj;

    }

    /**
     * Clicking the component to which this is attached will complete the current action
     *
     * @return \stdClass
     */
    public function getOnclickCompleteAction()
    {
        $obj = new \StdClass;
        $obj->action = 'complete-action';
        return $obj;
    }

    /**
     * Clicking the component to which this is attached will execute the given route.
     * Routes must be in the format Controller/Method/MenuId. If the format is incorrect an error will be thrown.
     * The controller's given method will be called and the menuid will be passed in.
     * MenuId is not required.
     *
     * @param string $route
     * @param bool $persist_route
     * @param array $saveparameters
     * @param bool $async
     * @param array $clickparameters
     * @return array
     */
    public function getOnclickRoute(string $route, $persist_route = true, array $saveparameters = array(), bool $async = true, array $clickparameters = array())
    {
        /** @var BootstrapView $this */

        /* menuid will also need to be passed to session if using this function,
        as the save is a two part process */

        /* route is always marked by slash */
        $routeparts = explode('/', $route);

        if (!isset($routeparts[1]) OR empty($routeparts[1])) {
            $this->errors[] = 'Route is not defined right. It should controller/method';
        }

        $obj = new \StdClass;
        $obj->action = 'submit-form-content';
        $obj->id = $route;
        $obj = $this->attachParameters($obj, $clickparameters);

        /* if we have also parameters to save we will first call
        server to save them and only then submit the second view */

        $identifier = $this->encryptParams($persist_route, $route, $saveparameters);

        $onclick = new \stdClass();
        $onclick->action = 'submit-form-content';
        $onclick->id = $identifier;

        if (!$async) {
            $obj->sync_open = 1;
            $onclick->sync_open = 1;
        }

        $output[] = $onclick;
        $output[] = $obj;
        return $output;

    }

    public function getOnclickOpenApp($server, $api_key)
    {
        $open = new \stdClass();
        $open->action = 'open-appzio-app';
        $open->server = $server;
        $open->api_key = $api_key;
        return $open;
    }

    public function getOnclickGooglePlaces($variableid, $parameters = array())
    {
        $open_maps = new \StdClass;
        $open_maps->action = 'choose-google-place';
        $open_maps->custom_dialog = 0;
        $open_maps->variable = $variableid;
        $open_maps = $this->attachParameters($open_maps, $parameters);
        return $open_maps;
    }

    /**
     * Clicking the component to which the returned value is attached will open a particular action.
     * This is used to have one screen "on top" of the other.
     *
     * @param bool $permaname
     * @param bool $actionid
     * @param array $parameters
     * @param bool $route
     * @param bool $persist_route
     * @param array $saveparams
     * @return array|\stdClass
     */
    public function getOnclickOpenAction($permaname = false, $actionid = false, $parameters = array(), $route = false, $persist_route = true, $saveparams = array())
    {

        if ($permaname) {
            $actionid = $this->model->getActionidByPermaname($permaname);
        }

        $open = new \stdClass();
        $open->action = 'open-action';
        $open->action_config = $actionid;
        $open = $this->attachParameters($open, $parameters);

        if ($route) {
            /* route is always marked by slash */
            $routeparts = explode('/', $route);

            if (!isset($routeparts[1]) OR empty($routeparts[1])) {
                $this->errors[] = 'Route is not defined right. Route example: controller/method';
            }

            // add the route to target
            $open->id = $route;
        }

        if ($route OR $saveparams) {
            /* this will save async */
            $identifier = $this->encryptParams($persist_route, $route, $saveparams, $actionid);
            $obj = new \StdClass;
            $obj->action = 'submit-form-content';
            $obj->id = $identifier;
            //$obj = $this->attachParameters($obj,$parameters);

            $output[] = $obj;
            $output[] = $open;
            return $output;
        }

        return $open;

    }

    /**
     * Clicking on the component that the returned value is attached to will open the given branch.
     *
     * @param bool $branchid
     * @param array $parameters
     * @param bool $route
     * @param bool $persist_route
     * @param array $saveparams
     * @return array|\stdClass
     */
    public function getOnclickOpenBranch($branchid = false, $parameters = array(), $route = false, $persist_route = true, $saveparams = array())
    {

        $open = new \stdClass();
        $open->action = 'open-branch';
        $open->action_config = $branchid;
        $open = $this->attachParameters($open, $parameters);

        if ($route) {
            /* route is always marked by slash */
            $routeparts = explode('/', $route);

            if (!isset($routeparts[1]) OR empty($routeparts[1])) {
                $this->errors[] = 'Route is not defined right. It should controller/method';
            }

            // add the route to target
            $open->id = $route;
        }

        if ($route OR $saveparams) {
            /* this will save async */
            $identifier = $this->encryptParams($persist_route, $route, $saveparams, $actionid);
            $obj = new \StdClass;
            $obj->action = 'submit-form-content';
            $obj->id = $identifier;
            //$obj = $this->attachParameters($obj,$parameters);

            $output[] = $obj;
            $output[] = $open;
            return $output;
        }

        return $open;
    }


    /**
     * @param $persist_route
     * @param bool $route
     * @param array $saveparameters
     * @param bool $actionid
     * @return string
     */
    private function encryptParams($persist_route, $route = false, $saveparameters = array(), $actionid = false)
    {

        $persist_route = $persist_route == true ? 1 : 0;

        $actionid = $actionid ? $actionid : $this->action_id;

        $persist = 'persist_route_' . $actionid;
        $current = 'current_route_' . $actionid;

        $saveparameters[$persist] = $persist_route;
        $saveparameters[$current] = $route;
        $saveparameters['save_async'] = 1;
        $identifier = md5(serialize($saveparameters) . $route . $persist_route);

        /* These are marked for saving, but not actually saved to session
        yet, only if matching menuid is actually clicked, they would get
        saved by the ArticleFactory. This save is like an intent to possibly
        save to session. */

        $this->model->click_parameters_to_save[$identifier] = $saveparameters;
        return $identifier;

    }

    /**
     * Clicking the component to which the returned object is attached will trigger the upload image dialog.
     * The image path will be saved in the variable passed to this method.
     *
     * @param string $variablename
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickImageUpload(string $variablename, $parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'upload-image';

        if ($this->model->getVariableId($variablename)) {
            $obj->variable = $this->model->getVariableId($variablename);
        } else {
            $obj->variable = $variablename;
        }

        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * Clicking the component to which the returned object is attached will ask for push notification permissions.
     *
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickPushPermissions($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'push-permission';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }


    /* social sdks
        tokens are sent by the client as variables. Look at the variable naming
        by creating the onclick and then checking from debug action / app's variables
    */

    /**
     * Clicking the component to which the returned object is attached will trigger the google authentication dialog
     *
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickGoogleLogin($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'google-login';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }


    /**
     * Clicking the component to which the returned object is attached will logout the current user
     *
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickGoogleLogout($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'google-logout';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * @param array $parameters
     * <code>
     * array(
     *   'fb_title' => 'my title',
     *   'fb_message' => 'my share msg'
     * </code>
     * @return \stdClass
     */
    public function getOnclickFacebookInvite($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'fb-invite';
        $required = array('fb_title', 'fb_message');

        $obj = $this->attachParameters($obj, $parameters, array(), $required);

        return $obj;
    }

    /* this normally works only with category games */
    public function getOnclickFacebookAppInvite($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'fb-appinvite';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    public function getOnclickFacebookLogin($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'fb-login';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    public function getOnclickFacebookLogout($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'fb-logout';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }


    public function getOnclickTwitterLogin($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'fb-logout';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }


    /**
     * Clicking the component to which the returned object is attached will close the popup defined in the parameters
     *
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickClosePopup($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'close-popup';
        $obj = $this->attachParameters($obj, $parameters);
        return $obj;
    }

    /**
     * Clicking the component to which the returned object is attached will make a list branches call.
     * This call will reload the list of branches and actions.
     * It's useful when you want to update the state of your app.
     *
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickListBranches($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'list-branches';
        $obj = $this->attachParameters($obj, $parameters);
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
    public function getOnclickLocation($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'ask-location';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * Clicking the component to which the returned object is attached will open the given url in the browser
     *
     * @param $url // valid url (can be also tel://3391282822 for example)
     * @param array $parameters
     * <code>
     * $array = array(
     * );
     * @return \stdClass
     */
    public function getOnclickOpenUrl($url, $parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'open-url';
        $obj->action_config = $url;
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * Will create a button for adding a calendar event
     *
     * @param array $parameters
     * <code>
     * $array = array(
     * 'starttime' => time()+700
     * 'endtime' => time()+1400,
     * 'organizer' => 'My Name',
     * 'organizer_email' => 'myemail@domain.com',
     * 'subject' => 'Checkup',
     *
     * // optional
     * 'description' => 'Event description',
     * 'location' => 'Event location',
     * 'repeat_daily_until' => unixtime,
     * 'repeat_weekly_until' =>  unixtime,
     * 'repeat_monthly_until' =>  unixtime,
     * 'repeat_yearly_until' =>  unixtime,
     * 'url' =>  'https://appzio.com',
     * 'invitees' => array('invitee1@appzio.com','invitee2@appzio.com'),
     *
     * // if this is set to true, we won't email the invitations to invited people
     * 'dont_send_invites' => true
     *
     * );
     * @return \stdClass
     */
    public function getOnclickCalendarEvent($parameters)
    {
        /** @var BootstrapView $this */

        $calpath = 'documents/games/' . $this->model->appid . '/calendars/';
        $path = $_SERVER['DOCUMENT_ROOT'] . dirname($_SERVER['PHP_SELF']) . $calpath;

        if (!is_dir($path)) {
            mkdir($path, 0777);
        }

        $template = $this->getCalendarTemplate($parameters);
        $filename = time() . \Helper::generateShortcode(5) . '.ics';
        file_put_contents($path . $filename, $template);

        if (isset($parameters['invitees']) AND is_array($parameters['invitees']) AND $parameters['invitees']) {
            if (!isset($parameters['dont_send_invites'])) {
                foreach ($parameters['invitees'] as $invitee) {
                    // this should add the email to be sent using the generated file as an attachment
                }
            }
        }

        $obj = new \stdClass();
        $obj->action = 'open-url';
        $obj->action_config = \Yii::app()->params['siteURLssl'] . '/' . $calpath . $filename;
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }


    /**
     * TODO
     * @param $title
     * @param $message
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickShowMessage($title, $message, $parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'show-message';
        $obj->title = $title;
        $obj->action_config = $message;
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * TODO
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickGoHome($parameters = array())
    {
        $obj = new \stdClass();
        $obj->action = 'go-home';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

    /**
     * TODO
     * @param bool $ios_product_id
     * @param bool $android_product_id
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickPurchase($ios_product_id = false, $android_product_id = false, $subscription = false, array $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'inapp-purchase';
        $onclick->producttype_android = 'inapp';
        $onclick->producttype_ios = 'inapp';

        if ($subscription) {
            $onclick->producttype_android = 'subs';
        }

        $onclick->product_id_ios = $ios_product_id;
        $onclick->product_id_android = $android_product_id;

        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * TODO
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickPurchaseRestore($parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'inapp-restore';
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * TODO
     * @param $productid
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickBraintreePurchase($productid, $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'braintree-purchase';
        $onclick->purchase_product_id = $productid;
        $onclick = $this->attachParameters($onclick, $parameters, array());
        return $onclick;
    }

    /**
     * Clicking the component to which the returned object is attached will open the app sidemenu.
     * This is often used when you are using a custom header and want to open the side menu when clicking on an icon.
     *
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickOpenSidemenu($parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'open-sidemenu';
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * Clicking the component to which the returned object is attached will close the app sidemenu.
     * This is often used when you are using a custom side navigation and want to close the side menu when clicking on an icon.
     *
     * @return \stdClass
     */
    public function getOnclickCloseSidemenu()
    {
        $onclick = new \stdClass();
        $onclick->action = 'close-side-menu';
        return $onclick;
    }

    /**
     * TODO
     * @param $beaconid
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickMonitorRegion($beaconid, $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'monitor-region';
        $onclick->region = new \stdClass();
        $onclick->monitor_inside_beacons = 1;
        $onclick->region->region = $beaconid;
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * TODO
     * @param $region_id
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickStopRegion($region_id, $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'monitor-region';
        $onclick->region = new \StdClass();
        $onclick->region->region_id = $region_id;
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * TODO
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickStopAllRegions($parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'stop-all-regions';
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * TODO
     * @param $region_id
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickFindBeacons($region_id, $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'find-beacons';
        $onclick->region = new \StdClass();
        $onclick->region->region_id = $region_id;
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }

    /**
     * TODO
     * @param string $adcolony_zone . If this is not defined, will use Google interstitial.
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickOpenInterstitialAd(string $adcolony_zone = '', $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'open-interstitial';
        $onclick->adcolony_zoneid = $adcolony_zone;
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }


    /**
     * TODO
     * @param $container_id
     * @param string $direction
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickSwipeStackControl($container_id, $direction = 'right', $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'swipe-' . $direction;
        $onclick->container_id = $container_id;
        $onclick = $this->attachParameters($onclick, $parameters);
        return $onclick;
    }



    public function getOnclickSwipeDelete($container_id, $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'swipe-delete';
        $onclick->container_id = $container_id;
        $onclick->send_ids = 1;
        $onclick = $this->attachParameters($onclick,$parameters);
        return $onclick;
    }


    /* you can check whether application can open a specific app url
        requires variable, as the function will update that variable
        with the result of the call
    */

    /**
     * TODO
     * @param $scheme_url
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickCheckSchme($scheme_url, $parameters = array())
    {
        $onclick = new \stdClass();
        $onclick->action = 'check-scheme';
        $onclick->action_config = $scheme_url;
        $required = array('variable');
        $onclick = $this->attachParameters($onclick, $parameters, array(), $required);
        return $onclick;
    }

    /**
     * @param array $parameters
     * @return \stdClass
     */
    public function getOnclickShare($parameters = array())
    {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->action = 'share';
        $obj = $this->attachParameters($obj, $parameters);

        return $obj;
    }

}