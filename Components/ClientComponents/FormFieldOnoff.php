<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;
use function is_array;

trait FormFieldOnoff {

    /**
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

    public function getComponentFormFieldOnoff(array $parameters=array(),array $styles=array()){
        /** @var BootstrapView $this */

        $type =  isset($parameters['type']) ? $parameters['type'] : '' ;
        $value = isset($parameters['value']) ? $parameters['value'] : 0;

        $obj = new \stdClass;
        $obj->type = ( $type == 'toggle' ? 'toggle' : 'field-checkbox' );
        $obj->content = $value;

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
    }
}