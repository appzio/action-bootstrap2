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

        $title = isset($parameters['title']) ? $parameters['title'] : '{#title#}';
        $btn_title = isset($parameters['btn_title']) ? $parameters['btn_title'] : '';
        $action = isset($parameters['btn_onclick']) ? $parameters['btn_onclick'] : $this->getOnclickSubmit('photo');

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
                'menu1600.png',
                array('onclick' => $menuAction),
                array(
                    "height" => "40",
                    "width" => "40",
                    "padding" => "5 0 5 0"
                )
            );
        } else {
            $close = $this->getOnclickTab(1);
            $top[] = $this->getComponentImage('div-close-icon.png',array('onclick' => $close,'style' => 'fauxheader_close'));
        }


        if(isset($parameters['logo']) AND $parameters['logo']){
            $top[] = $this->getComponentImage($parameters['logo'],[],['height' => '30','margin' => '15 0 15 0','width' => $this->screen_width - 77,'text-align' => 'center']);
        } else {
            $top[] = $this->getComponentText($title,array('uppercase' => true,'style' => 'jam_fauxheader_title'));
        }

        if(isset($parameters['right_menu']) AND $parameters['right_menu'] AND isset($parameters['right_menu']['icon'])) {
            $top[] = $this->getComponentImage($parameters['right_menu']['icon'],[
                'onclick' => $this->getOnclickOpenAction(false,$parameters['right_menu']['config'])
            ],[
                    'height' => '25'
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

        return $this->getComponentRow($top,array(),array('background-color' => $this->color_top_bar_color,
            'height' => '45','width' => $this->screen_width,'vertical-align' => 'middle','padding' => '0 0 0 0'));

    }



}