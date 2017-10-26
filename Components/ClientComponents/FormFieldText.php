<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait FormFieldText
 * This trait provides the basic text input component.
 *
 * @package Bootstrap\Components\Elements
 */
trait FormFieldText {

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
     * 'activation' => 'initially' //initially or keep-open,
     * 'empty' => '1'       // whether the field should be empty and not use submitted value
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */

    public function getComponentFormFieldText(string $field_content = '',array $parameters=array(),array $styles=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass;
        $obj->type = 'field-text';

        if(empty($field_content) AND isset($parameters['variable']) AND !isset($parameters['empty']) AND !isset($parameters['value'])){
            $this->model->getSubmittedVariableByName($parameters['variable']);
        }

        $obj->content = $field_content;

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        if(isset($parameters['uppercase']) AND isset($parameters['hint'])){
            $content = $this->model->localize($parameters['hint']);
            $obj->hint = strtoupper($content);
        }

        return $obj;
    }
}