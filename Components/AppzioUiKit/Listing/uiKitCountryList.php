<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

use Bootstrap\Components\BootstrapComponent;

trait uiKitCountryList
{
    public function uiKitCountryList($params=array(),$styles=array())
    {

        $custom_divider = $this->addParam('custom_divider', $params,false);
        $background_color = $this->addParam('background-color', $styles,$this->color_background_color);
        $color = $this->addParam('color', $styles,$this->color_text_color);
        $margin = $this->addParam('margin', $styles,'5 15 0 15');

        $countries = $this->model->getCountryCodes();

        foreach ($countries as $country=>$code){
            if($custom_divider){
                $row[] = $custom_divider;
            } else {
                $row[] = $this->getComponentText('',['style' => 'uikit_countrylist_divider']);
            }

            $row[] = $this->getComponentText($country,[],[
                'color' => $color,'margin' => $margin,'font-size' => '13'
            ]);

            $output[] = $this->getComponentColumn($row,['filter' => $country]);
            unset($row);
        }

        return $this->getComponentColumn($output,[],['background-color' => $background_color]);
    }

}