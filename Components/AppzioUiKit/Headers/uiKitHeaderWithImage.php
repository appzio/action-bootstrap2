<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;
use Bootstrap\Views\BootstrapView;

trait uiKitHeaderWithImage {

    public function uiKitHeaderWithImage(string $pic,string $text,$parameters=array(),$styles=array()){

        $row[] = $this->getComponentImage($pic, array(
            'imgwidth' => '60',
            'imgheight' => '60',
            'priority' => '9'
        ), array(
            'margin' => '8 0 8 17',
            'width' => '27',
            'crop' => 'round',
        ));

        $row[] = $this->getComponentText($text, array(), array(
            'font-size' => '12',
            'margin' => '8 0 8 10'
        ));

        $output[] = $this->getComponentRow($row);

        if(!isset($parameters['hide_divider'])){
            $output[] = $this->uiKitDivider();
        }

        $base['background-color'] = '#F6F6F6';
        $base['vertical-align'] = 'top';

        $styles = array_merge($base,$styles);

        return $this->getComponentColumn($output,$parameters,$styles);

    }


}