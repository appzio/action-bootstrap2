<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait FormFieldUploadVideo {

    /**
     * @param $field_content string, should be an video file name or stream url
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

    public function getComponentFormFieldUploadVideo(string $field_content = '',array $parameters=array(),array $styles=array()){
        /** @var BootstrapView $this */

        $obj = new \stdClass;
        $obj->type = 'field-upload-video';
        $obj->content = ( !empty($field_content) ? $field_content : '' );

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
    }
}