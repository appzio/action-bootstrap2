<?php

namespace packages\actionMexample\Components;
use Bootstrap\Components\BootstrapComponent;
use function str_replace;
use function str_replace_array;
use function strtolower;
use function substr;

trait getDivPhoneNumbers {

    /**
     * @param $content string, no support for line feeds
     * @param array $styles 'margin', 'padding', 'orientation', 'background', 'alignment', 'radius', 'opacity',
     * 'orientation', 'height', 'width', 'align', 'crop', 'text-style', 'font-size', 'text-color', 'border-color',
     * 'border-width', 'font-android', 'font-ios', 'background-color', 'background-image', 'background-size',
     * 'color', 'shadow-color', 'shadow-offset', 'shadow-radius', 'vertical-align', 'border-radius', 'text-align',
     * 'lazy', 'floating' (1), 'float' (right | left), 'max-height', 'white-space' (no-wrap), parent_style
     * @param array $parameters selected_state, variable, onclick, style
     * @return \stdClass
     */

    public function getDivPhoneNumbers(){
        /** @var BootstrapComponent $this */

        $countrycodes = $this->model->getCountryCodes();
        $ouput = array();
        $list = '';

        //$content[] = $this->getComponentText('{#choose_your_country#}');

        foreach ($countrycodes as $name => $code){
            $list .= $code .';' .$name .';';
        }

        $list = substr($list, 0,-1);

        $value = $this->model->getSubmittedVariableByName('selected_country') ? $this->model->getSubmittedVariableByName('selected_country') : $this->model->sessionGet('selected_country');


        $content[] = $this->getComponentFormFieldList($list,array(
            'variable' => 'country_selected',
            'style' => 'mreg_selectlist',
            'value' => $value
        ));

        $cols[] = $this->getComponentText('{#cancel#}',array('style' => 'mreg_small_btn','onclick' => $this->getOnclickHideDiv('countries')));
        $cols[] = $this->getComponentText('{#select#}',array('style' => 'mreg_small_btn',
            'onclick' => $this->getOnclickSubmit('selectcountry')
        )
        );

        $content[] = $this->getComponentRow($cols,array(),array(
            'text-align' => 'center'
        ));

        return $this->getComponentColumn($content,array(
            'style' => 'mreg_divbox'
        ),array(

        ));


    }

}