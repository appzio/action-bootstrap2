<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Components\BootstrapComponent;

trait uiKitHintedTextField {

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

    public function uiKitHintedTextField($hint,$variablename,$type='text', array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        $parameters['variable'] = $variablename;

        if($this->model->getValidationError($variablename)) {
            $error[] = $this->getComponentText($hint .' ', array('style' => 'steps_hint','uppercase' => true));
            $error[] = $this->getComponentText($this->model->getValidationError($variablename),array('style' => 'steps_error'));
            $out[] = $this->getComponentRow($error,array(),array('width' => '100%'));
        } else {
            $out[] = $this->getComponentText($hint, array('style' => 'steps_hint','uppercase' => true));
        }

        if(!isset($parameters['value'])){
            $val = $this->model->getSubmittedVariableByName($variablename) ? $this->model->getSubmittedVariableByName($variablename) : $this->model->getSavedVariable($variablename);
        } else {
            $val = $parameters['value'];
        }

        switch($type){
            case 'text':
                $out[] = $this->getComponentFormFieldText($val,
                    array_merge($parameters,array('style' => 'steps_field')
                ));
                break;

            case 'textarea':
                $out[] = $this->getComponentFormFieldTextArea($val,
                    array_merge($parameters,array('style' => 'steps_field_textarea')
                    ));
                break;

            case 'password':
                $out[] = $this->getComponentFormFieldPassword($val,
                    array_merge($parameters,array('style' => 'steps_field')
                    ));
                break;

            case 'noedit':
                $out[] = $this->getComponentText($val,array('style' => 'steps_field_noedit'));
                break;

        }

        if($this->model->getValidationError($variablename)){
            $out[] = $this->getComponentText('',array('style' => 'steps_field_divider_error'));
        } else {
            $out[] = $this->getComponentText('',array('style' => 'steps_field_divider'));
        }

        if($this->model->getValidationError($variablename.'_exists')){
            $err[] = $this->getComponentText('{#choose_another_email_or#} ',array('style' => 'email_exists_text'));
            $err[] = $this->getComponentText('{#return_to_login#}', array('style' => 'email_exists',
                'onclick' => $this->getOnclickOpenAction('login')));

            $out[] = $this->getComponentRow($err,array('style' => 'email_exists_row'));
        }


        return $this->getComponentColumn($out);
	}

}