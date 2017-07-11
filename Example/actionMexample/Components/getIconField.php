<?php

namespace packages\actionMexample\Components;
use Bootstrap\Components\BootstrapComponent;

trait getIconField {

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

    public function getIconField($field,$title,$icon=false){
        /** @var BootstrapComponent $this */

        $params['variable'] = $field;
        $params['hint'] = $title;
        $params['style'] = 'mreg_fieldtext';

        if($field == 'email'){
            $params['input_type'] = 'email';
        }elseif($field == 'phone'){
            $params['input_type'] = 'numeric';
        }

        if($icon){
            $col[] = $this->getComponentImage($icon,array('style' => 'mreg_icon_field'));
        } else {
            $col[] = $this->getComponentText('',array('style' => 'mreg_icon_field'));
        }

        if(stristr($field, 'password')){
            $col[] = $this->getComponentFormFieldPassword($this->model->getSubmittedVariableByName($field),$params);
        } else {
            $col[] = $this->getComponentFormFieldText($this->model->getSubmittedVariableByName($field),$params);
        }

        if(isset($this->model->validation_errors[$field])){
            $row[] = $this->getComponentText($this->model->validation_errors[$field],array('style' => 'mreg_error'));
            $row[] = $this->getComponentRow($col,array(),array('vertical-align' => 'middle'));
            return $this->getComponentColumn($row);
        }

        return $this->getComponentRow($col,array(),array('vertical-align' => 'middle'));
    }

}