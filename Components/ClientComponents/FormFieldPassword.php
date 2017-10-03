<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait FormFieldPassword
 * This trait provides access to the password input field.
 * Password input fields hide characters after they are written.
 *
 * @package Bootstrap\Components\Elements
 */
trait FormFieldPassword {

    /**
     * @param $content string, no support for line feeds
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

    public function getComponentFormFieldPassword(string $content,array $parameters=array(),array $styles=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass;
        $obj->type = 'field-password';

        if(empty($field_content) AND isset($parameters['variable']) AND !isset($parameters['empty'])){
            $field_content = $this->model->getSubmittedVariableByName($parameters['variable']);
        }

        $obj->content = ( !empty($field_content) ? $field_content : '' );

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
    }
}