<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait FormFieldTextArea
 * This trait provides access to the textarea component.
 * A textarea is a multi line input field.
 *
 * @package Bootstrap\Components\Elements
 */
trait FormFieldTextArea {

    /**
     * @param $field_content string, no support for line feeds
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'hint' => 'hint text',
     * 'height' => '40',
     * 'submit_menu_id' => 'someid',
     * 'maxlength', => '80',
     * 'input_type' => 'text',
     * 'activation' => '' ??
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */

    public function getComponentFormFieldTextArea(string $field_content,array $parameters=array(),array $styles=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass;
        $obj->type = 'field-textview';

        if(empty($field_content) AND isset($parameters['variable'])){
            if($this->model->getSubmittedVariableByName($parameters['variable'])){
                $field_content = $this->model->getSubmittedVariableByName($parameters['variable']);
            } elseif($this->model->getSavedVariable($parameters['variable'])){
                $field_content = $this->model->getSavedVariable($parameters['variable']);
            }
        }

        $obj->content = ( !empty($field_content) ? $field_content : '' );

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        /* crashes iOS if its missing */
        if(!isset($obj->hint)){
            $obj->hint = '';
        }

        return $obj;
    }
}