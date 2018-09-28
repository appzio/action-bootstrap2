<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitLocationSelectorDiv
{

    public function uiKitLocationSelectorDiv(array $params = array()){
        /** @var BootstrapComponent $this */

        $country = $this->addParam('country', $params);
        $city = $this->addParam('city', $params);
        $countries = $this->addParam('countries', $params);
        $cities = $this->addParam('cities', $params);

        if(!empty($cities)){
            $title = '{#choose_your_city#}';
        } else {
            $title = '{#choose_the_country#}';
        }

        $content[] = $this->getComponentText($title,[],[
            'text-align' => 'center',
            'padding' => '15 15 15 15',
            'width' => '100%',
            'margin' => '0 0 0 0',
            'font-size' => '13',
            'background-color' => $this->color_top_bar_color,'color' => $this->color_top_bar_text_color
        ]);


        $style['color'] = $this->color_top_bar_text_color;
        $style['background-color'] = $this->color_top_bar_color;
        $style['padding'] = '5 10 5 10';
        $style['border-radius'] = '4';
        $style['font-size'] = '13';
        $style['margin'] = '0 5 0 5';

        $style2 = $style;
        $style2['color'] = $this->color_top_bar_color;
        $style2['border-color'] = $this->color_top_bar_color;
        $style2['background-color'] = $this->color_top_bar_text_color;
        $style2['border-width'] = 1;

        if(!empty($cities)){
            $content[] = $this->getComponentFormFieldList($cities,array(
                'variable' => 'city_selected',
                'value' => $city
            ),['font-size' => 13,'width' => '80%']);
        } else {
            $content[] = $this->getComponentFormFieldList($countries,array(
                'variable' => 'country_selected',
                'value' => $country
            ),['font-size' => 13,'width' => '80%']);
        }


        $cols[] = $this->getComponentText('{#cancel#}',array(
            'onclick' => $this->getOnclickHideDiv('location_selector')),$style2);


        $location[] = $this->getOnclickHideDiv('location_selector');
        $location[] = $this->getOnclickLocation();
        $location[] = $this->getOnclickSubmit('checking/updatelocation/1',['delay' => '0.7']);

        $cols[] = $this->getComponentText('{#use_my_current_location#}',
            array('onclick' => $location),$style);

        $layout = new \stdClass();
        $layout->top = 0;
        $layout->left = 0;
        $layout->right = 0;

        $divparam = array(
            'background' => 'blur',
            'tap_to_close' => 1,
            'transition' => 'none',
            'layout' => $layout
        );

        $divparam2 = array(
            'transition' => 'none',
            'layout' => $layout
        );

        if(!$cities) {
            $cols[] = $this->getComponentText('{#select#}', array(
                'onclick' => [
                    //$this->getOnclickShowDiv('loader',$divparam2),
                    $this->getOnclickSubmit('selectcountry',['sync_open' => 1]),
                    //$this->getOnclickHideDiv('location_selector', ['delay' => '0.5']),
                    //$this->getOnclickShowDiv('location_selector', $divparam),
                    //$this->getOnclickHideDiv('loader', ['delay' => '0.5']),
                ]
            ), $style
            );
        } else {
            $cols[] = $this->getComponentText('{#select#}', array(
                'onclick' => [
                    $this->getOnclickHideDiv('location_selector'),
                    $this->getOnclickSubmit('selectcity'),
                ]
            ), $style
            );
        }

        $content[] = $this->getComponentSpacer(20);

        $content[] = $this->getComponentRow($cols,array(),array(
            'text-align' => 'center'
        ));

        return $this->getComponentColumn($content,array(
            'style' => 'uikit_div_location_selector'
        ));


    }
}