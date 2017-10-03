<?php

namespace Bootstrap\Components\Snippets\Forms;
use Bootstrap\Components\BootstrapComponent;

trait FormHintedField {

    /**
     * Shows a field with a title with predefined styling. Styling can be overriden in your own styles.json either
     * for the entire app, or for your specific action. Component checks for your model for any validation errors
     * and displays the validation error inline if it exists. Pointer is the variable name.
     *
     * @param $field_title -- field title
     * @param $variablename -- variable for this field
     * @param string $type -- text, textarea, password, noedit
     * @param array $parameters -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentParameter
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     * @link https://docs.appzio.com
     * @link https://appzio.com
     */

    public function FormHintedField($field_title, $variablename, $type='text', array $parameters=array(), array $styles=array()) {
        /** @var BootstrapComponent $this */

        $parameters['variable'] = $variablename;

        if($this->model->getValidationError($variablename)) {
            $error[] = $this->getComponentText($field_title .' ', array('style' => 'steps_hint','uppercase' => true));
            $error[] = $this->getComponentText($this->model->getValidationError($variablename),array('style' => 'steps_error'));
            $out[] = $this->getComponentRow($error,array(),array('width' => '100%'));
        } else {
            $out[] = $this->getComponentText($field_title, array('style' => 'steps_hint','uppercase' => true));
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