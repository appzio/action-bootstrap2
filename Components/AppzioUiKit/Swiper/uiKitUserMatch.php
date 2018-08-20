<?php

namespace Bootstrap\Components\AppzioUiKit\Swiper;
use Bootstrap\Components\BootstrapComponent;

trait uiKitUserMatch {

    public $page = 0;


    public function uiKitUserMatch(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        $left_image = isset($parameters['left_image']) ? $parameters['left_image'] : 'anonymous-person.png';
        $right_image = isset($parameters['right_image']) ? $parameters['right_image'] : 'anonymous-person.png';
        $button1_text = isset($parameters['button1_text']) ? $parameters['button1_text'] : false;
        $button2_text = isset($parameters['button2_text']) ? $parameters['button2_text'] : false;
        $button1_onclick = isset($parameters['button1_onclick']) ? $parameters['button1_onclick'] : false;
        $button2_onclick = isset($parameters['button2_onclick']) ? $parameters['button2_onclick'] : false;
        $title = isset($parameters['title']) ? $parameters['title'] : '';
        $subtext = isset($parameters['subtext']) ? $parameters['subtext'] : '';
        
        $col[] = $this->getComponentText($title,['style' => 'uikit_usermatch_title']);
        $imgs[] = $this->getComponentImage($left_image,['style' => 'uikit_usermatch_image']);
        $imgs[] = $this->getComponentImage($right_image,['style' => 'uikit_usermatch_image']);
        $col[] = $this->getComponentRow($imgs,['style' => 'uikit_usermatch_images']);
        $col[] = $this->getComponentText($subtext,['style' => 'uikit_usermatch_subtext']);

        $col[] = $this->uiKitButtonHollow($button1_text,['onclick' => $button1_onclick]);

        if($button2_text){
            $col[] = $this->getComponentSpacer(20);
            $col[] = $this->uiKitButtonFilled($button2_text,['onclick' => $button2_onclick]);
        }

        return $this->getComponentColumn($col);


    }



}