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
        
        
        $no_divider = $this->addParam('no_divider', $parameters,false);

        $parameters['variable'] = $variablename;

	    if ( isset($parameters['uppercase']) AND $parameters['uppercase'] ) {
	        $title_params['uppercase'] = true;
        }

        if(!$no_divider) {
            $title_params['style'] = 'uikit_steps_hint';
            $out[] = $this->getComponentText($hint, $title_params);
        } else {
            if($this->model->getValidationError($variablename)) {
                $title_params['style'] = 'uikit_steps_hint_error';
                $out[] = $this->getComponentText($hint, $title_params);
            } else{
                $title_params['style'] = 'uikit_steps_hint';
                $out[] = $this->getComponentText($hint, $title_params);
            }
        }

        if(!isset($parameters['value'])){
            $val = $this->model->getSubmittedVariableByName($variablename) ? $this->model->getSubmittedVariableByName($variablename) : $this->model->getSavedVariable($variablename);
        } else {
            $val = $parameters['value'];
        }

        if(!$val){
            $val = $this->model->getSavedVariable($variablename);
        }

        switch($type){
            case 'text':
                $out[] = $this->getComponentFormFieldText($val,
                    array_merge(array('style' => 'uikit_hinted_text'), $parameters)
                );
                break;

            case 'email':
                $parameters['input_type'] = 'email';
                $out[] = $this->getComponentFormFieldText($val,
                    array_merge(array('style' => 'uikit_hinted_text'), $parameters)
                );
                break;

            case 'phone':
                $parameters['input_type'] = 'phone';
                $out[] = $this->getComponentFormFieldText($val,
                    array_merge(array('style' => 'uikit_hinted_text'), $parameters)
                );
                break;

            case 'number':
                $parameters['input_type'] = 'number';
                $out[] = $this->getComponentFormFieldText($val,
                    array_merge(array('style' => 'uikit_hinted_text'), $parameters)
                );
                break;

            case 'textarea':
                $out[] = $this->getComponentFormFieldTextArea($val,
	                array_merge(array('style' => 'uikit_hinted_textarea'), $parameters)
                );
                break;

            case 'password':
                $out[] = $this->getComponentFormFieldPassword($val,
                    array_merge(array('style' => 'uikit_hinted_text'), $parameters)
                );
                break;

            case 'noedit':
                $out[] = $this->getComponentText($val,array('style' => 'uikit_hinted_text_noedit'));
                break;

        }

        if(!$no_divider){
            if($this->model->getValidationError($variablename)) {
                $out[] = $this->getComponentText('',[],['background-color' => '#F12617','height' => '1', 'width' => '100%']);
                $out[] = $this->getComponentText($this->model->getValidationError($variablename),array('style' => 'uikit_steps_error'));
            } else {
                $out[] = $this->getComponentText('',[],['background-color' => '#D9DBDA','height' => '1', 'width' => '100%','margin' => '5 0 5 0']);
            }
        }

        return $this->getComponentColumn($out);
	}

}