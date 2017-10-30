<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitTitlePriceLocation {

    public function uiKitTitlePriceLocation($title,$price,$city){

        $row[] = $this->getComponentText($title,array(),array(
            'margin' => '8 0 0 15',
            'font-size' => '20'
        ));
        $row[] = $this->getComponentText($price,array(),array(
            'float' => 'right',
            'floating' => '1',
            'color' => '#3EB439',
            'font-size' => '20',
            'margin' => '8 15 0 0'
        ));
        $output[] = $this->getComponentRow($row);
        unset($row);

        $row[] = $this->getComponentImage('uikit-icon-map-link.png',array(),array(
            'margin' => '8 0 8 15',
            'width' => '30'
        ));

        $row[] = $this->getComponentText($city,array(),array(
            'font-size' => '12',
            'margin' => '8 0 8 10'
        ));
        $output[] = $this->getComponentRow($row);
        $output[] = $this->uiKitDivider();

        return $this->getComponentColumn($output,array(),array(
            'background-color' => '#F6F6F6',
            'vertical-align' => 'top'
        ));

    }
    


}