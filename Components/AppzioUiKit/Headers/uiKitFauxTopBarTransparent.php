<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitFauxTopBarTransparent {


    /**
     * This is a component for creating a top bar which can include logo, custom buttons etc.
     * @param array $parameters
     * title, btn_title, btn_onclick, route_back, mode, logo, right_menu
     * @return mixed
     */
    public function uiKitFauxTopBarTransparent($parameters = array()){
        /** @var BootstrapComponent $this */

        $title = isset($parameters['title']) ? $parameters['title'] : false;
        $btn_title = isset($parameters['btn_title']) ? $parameters['btn_title'] : '';
        $action = isset($parameters['btn_onclick']) ? $parameters['btn_onclick'] : $this->getOnclickSubmit('photo');
        $color = isset($parameters['icon_color']) ? $parameters['icon_color'] : 'white';

        if($this->notch){
            $height = '80';
            $padding = '0 0 10 0';
        } else {
            if($this->transparent_statusbar AND $this->phone_statusbar){
                $height = '60';
                $padding = '0 0 10 0';
            } else {
                $height = '40';
                $padding = '0 0 6 0';
            }
        }

        if(isset($parameters['route_back'])){
            $close = $this->getOnclickRoute($parameters['route_back']);
            $top[] = $this->getComponentImage('div-back-icon.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'gohome'){
            $close = $this->getOnclickGoHome();
            $top[] = $this->getComponentImage('div-back-icon.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'close'){
            $close = $this->getOnclickClosePopup();
            $top[] = $this->getComponentImage('close-icon-div.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'close-go-home'){
            $close = $this->getOnclickGoHome();
            $top[] = $this->getComponentImage('close-icon-div.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'sidemenu'){
            $menuAction = $this->getOnclickOpenSidemenu();
            $top[] = $this->getComponentImage(
                'white_hamburger_icon.png',
                array('onclick' => $menuAction),
                array(
                    "height" => "24",
                    "width" => "24",
                    "margin" => "0 0 0 13",
                    'shadow-color' => '#545050',
                    'shadow-radius' => 2,
                    'shadow-offset' => '0 0',
                )
            );
        } else {
            $close = $this->getOnclickTab(1);
            $top[] = $this->getComponentImage('div-close-icon.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }

        if(isset($parameters['notification_count']) AND $parameters['notification_count']) {
            $center_width = $this->screen_width - 137;
            $top[] = $this->getComponentVerticalSpacer(30);
        } else {
            $center_width = $this->screen_width - 77;
        }

        if(isset($parameters['logo']) AND $parameters['logo']){
            $top[] = $this->getComponentImage($parameters['logo'],[],['height' => '30','margin' => '4 0 5 0','width' => $center_width,'text-align' => 'center']);
        } elseif($title) {
            if($color == 'white'){
                $top[] = $this->getComponentText($title,array(),[
                    'text-align' => 'center','width' => $center_width,
                    'margin' => '8 0 5 0','font-size' => '15','color' => '#ffffff']);
            } else {
                $top[] = $this->getComponentText($title,array(),[
                    'text-align' => 'center','width' => $center_width,
                    'margin' => '8 0 5 0','font-size' => '15','color' => '#000000']);
            }
        } elseif($title) {
            $top[] = $this->getComponentText($title,[],['color' => '#fffffff']);
        } else {
            $top[] = $this->getComponentVerticalSpacer($center_width);
        }

        if(isset($parameters['right_menu']) AND $parameters['right_menu'] AND isset($parameters['right_menu']['icon'])) {
            $top[] = $this->getComponentImage($parameters['right_menu']['icon'],[
                'onclick' => $this->getOnclickOpenAction(false,$parameters['right_menu']['config'])
            ],[
                    'height' => '25',
                    'padding' => '1 0 0 0',
                    'shadow-color' => '#545050',
                    'shadow-radius' => 2,
                    'shadow-offset' => '0 0',
                ]
            );
        }

        if($btn_title){
            if($btn_title == 'X'){
                $top[] = $this->getComponentImage('div-close-icon.png',array('onclick' => $action,'style' => 'fauxheader_close'));
            } else {
                $top[] = $this->getComponentText($btn_title,array('onclick' => $action,'style' => 'fauxheader_add'));
            }
        } else {
            $top[] = $this->getComponentText('',array('style' => 'fauxheader_add'));
        }

        $layout = new \stdClass();
        $layout->top = 15;
        $layout->left = 0;
        $layout->right = 0;
        $layout->center = 0;

        return $this->getComponentRow($top,array(),array(
            'height' => $height,
            //'border' => 1,
            //'border-color' => '#ffffff',
            'width' => 'auto',
            'text-align' => 'center',
            'vertical-align' => 'middle',
            'layout' => $layout,
            'padding' => $padding));

    }



}