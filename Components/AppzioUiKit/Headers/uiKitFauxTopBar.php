<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitFauxTopBar {


    /**
     * This is a component for creating a top bar which can include logo, custom buttons etc.
     * @param array $parameters
     * title, btn_title, btn_onclick, route_back, mode, logo, right_menu
     * @return mixed
     */
    public function uiKitFauxTopBar($parameters = array()){
        /** @var BootstrapComponent $this */

        $title = isset($parameters['title']) ? $parameters['title'] : false;
        $btn_title = isset($parameters['btn_title']) ? $parameters['btn_title'] : '';
        $action = isset($parameters['btn_onclick']) ? $parameters['btn_onclick'] : $this->getOnclickSubmit('photo');
        $hairline = isset($parameters['hairline']) ? $parameters['hairline'] : false;
        $color = isset($parameters['icon_color']) ? $parameters['icon_color'] : 'white';

        if(!$color){
            $color = 'black';
        }

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

        $color = $this->getTextColour($this->color_top_bar_text_color);

        if(isset($parameters['route_back'])){
            $close = $this->getOnclickRoute($parameters['route_back']);
            $top[] = $this->getComponentImage('div-back-icon.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'gohome'){
            $close = $this->getOnclickGoHome();

            $top[] = $this->getComponentImage(
                $color.'-div-back-icon.png',
                array('onclick' => $close),
                array(
                    "height" => "28",
                    "width" => "28",
                    "margin" => "6 0 0 6"
                )
            );

        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'close'){
            $close = $this->getOnclickClosePopup();
            $top[] = $this->getComponentImage('close-icon-div.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'close-go-home'){
            $close = $this->getOnclickGoHome();
            $top[] = $this->getComponentImage('close-icon-div.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }elseif(isset($parameters['mode']) AND $parameters['mode'] == 'sidemenu'){
            $menuAction = $this->getOnclickOpenSidemenu();
            $top[] = $this->getComponentImage(
                $color.'_hamburger_icon.png',
                array('onclick' => $menuAction),
                array(
                    "height" => "24",
                    "width" => "24",
                    "margin" => '4 0 0 13'
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
                    'margin' => '9 0 5 0','font-size' => '16','color' => '#ffffff']);
            } else {
                $top[] = $this->getComponentText($title,array(),[
                    'text-align' => 'center','width' => $center_width,
                    'margin' => '9 0 5 0','font-size' => '16','color' => '#000000']);
            }
        } else {
            $top[] = $this->getComponentVerticalSpacer($center_width);
        }

        if(isset($parameters['notification_count']) AND $parameters['notification_count']){
            $top[] = $this->getComponentText($parameters['notification_count'],[
                'onclick' => $this->getOnclickOpenAction('notifications')
            ],[
                'color' => '#ffffff',
                'font-size' => '12',
                'font-weight' => 'bold',
                'margin' => '7 5 7 5',
                'text-align' => 'center',
                'border-radius' => '4',
                'background-color' => '#00BED2',
                'width' => '20',
                'height' => '18'
            ]);
        }

        if(isset($parameters['right_icon']) AND isset($parameters['right_action'])){
            $top[] = $this->getComponentImage($parameters['right_icon'],[
                'onclick' => $parameters['right_action']
            ],[
                    'height' => '25','margin' => '4 0 0 0'
                ]
            );
        }elseif(isset($parameters['right_menu']) AND $parameters['right_menu'] AND isset($parameters['right_menu']['icon'])) {
            $top[] = $this->getComponentImage($parameters['right_menu']['icon'],[
                'onclick' => $this->getOnclickOpenAction(false,$parameters['right_menu']['config'])
            ],[
                    'height' => '25','margin' => '4 0 0 0'
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

        if($hairline){
            $out[] = $this->getComponentRow($top,array(),array('background-color' => $this->color_top_bar_color,
                'height' => $height,'width' => $this->screen_width,'vertical-align' => 'bottom','padding' => $padding));

            $out[] = $this->getComponentText('',[],['height' => 2,'background-color' => $hairline,'width' => '100%']);
            return $this->getComponentColumn($out,[],[
                'vertical-align' => 'bottom']);
        } else {
            return $this->getComponentRow($top,array(),array('background-color' => $this->color_top_bar_color,
                'height' => $height,
                'padding' => $padding,
                'width' => $this->screen_width,
                'vertical-align' => 'bottom'));
        }

    }

    function getTextColour($hex){
        list($red, $green, $blue) = sscanf($hex, "#%02x%02x%02x");
        $luma = ($red + $green + $blue)/3;

        if ($luma < 128){
            $textcolour = "white";
        }else{
            $textcolour = "black";
        }
        return $textcolour;
    }




}