<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Components\BootstrapComponent;

trait uiKitHintedSelectButtonField {

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

    public function uiKitHintedSelectButtonField($hint,$variablename,$onclick, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        $parameters['variable'] = $variablename;

        if($this->model->getValidationError($variablename)) {
            $error[] = $this->getComponentText($hint .' ', array('style' => 'steps_hint','uppercase' => true));
            $error[] = $this->getComponentText($this->model->getValidationError($variablename),array('style' => 'steps_error'));
            $out[] = $this->getComponentRow($error,array(),array('width' => '100%'));
        } else {
            if(isset($parameters['big_form_title'])){
                $out[] = $this->uiKitFormSectionHeader($hint);
            } else {
                $out[] = $this->getComponentText($hint, array('style' => 'steps_hint','uppercase' => true));
            }
        }

        if(!isset($parameters['value'])){
            $val = $this->model->getSavedVariable($variablename.'_name') ? $this->model->getSavedVariable($variablename.'_name') : '{#click_to_select#}';
        } else {
            $val = $parameters['value'];
        }

        $icon = isset($parameters['icon']) ? $parameters['icon'] : 'uikit-select-form-icon.png';

        if(isset($parameters['editable_field'])){
            $row[] = $this->getComponentFormFieldText($val,array('style' => 'steps_field_noedit','variable' => $variablename));
            $row[] = $this->getComponentImage($icon,array('style' => 'ukit_form_field_select_icon','onclick' => $onclick));
            $out[] = $this->getComponentRow($row,array());
        } else {
            $row[] = $this->getComponentText($val,array('style' => 'steps_field_noedit','variable' => $variablename));
            $row[] = $this->getComponentImage($icon,array('style' => 'ukit_form_field_select_icon'));
            $out[] = $this->getComponentRow($row,array('onclick' => $onclick));
        }

        if(isset($parameters['big_form_title'])) {
            $out[] = $this->getComponentText('', array('style' => 'steps_field_divider_small'));
        }elseif($this->model->getValidationError($variablename)){
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

        if(isset($parameters['big_form_title'])){
            return $this->getComponentColumn($out,array(),array('background-color'=> '#ffffff'));
        } else {
            return $this->getComponentColumn($out);
        }


	}

}