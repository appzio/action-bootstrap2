<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;
use function is_array;

/**
 * Trait FormFieldOnoff
 * @package Bootstrap\Components\Elements
 */
trait FormFieldOnoff {

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
     * 'activation' => 'initially' //initially or keep-open,
     * 'empty' => '1'       // whether the field should be empty and not use submitted value
     * );
     * </code>
     * @param array $styles
     * <code>
     * $array = array(
     * 'margin' => '0 0 0 0',
     * 'padding' => '0 0 0 0',
     * 'width' => '200', // or 100%
     * 'height' => '400',
     * 'max_height' => '500',
     * 'background-color' => '#ffffff',
     * 'background-image' => 'filename.png',
     * 'background-size' => 'cover', // or 'contain', 'top' (default)
     * 'crop' => 'round', // or 'yes'
     * 'vertical-align' => 'middle',
     * 'text-align' => 'center',
     * 'font-size' => '14',
     * 'font-ios' => 'Roboto',
     * 'font-weight' => 'Bold',
     * 'font-style' => 'Italic',
     * 'font-android' => 'Roboto',
     * 'color' => '#000000',
     * 'white-space' => 'nowrap',
     * 'children_style' => 'style-class-name' // this is used only in menu, progress and field-list components
     * 'floating' => '1',
     * 'float' => 'right',
     * 'parent_style' => 'style-class-name',
     * 'shadow-color' => '#000000',
     * 'shadow-offset' => '0 1',
     * 'shadow-radius' => '5',
     * 'border-width' => '1',
     * 'border-color' => '#000000',
     * 'border-radius' => '4',
     * 'opacity' => '0.4',
     * );
     * </code>
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