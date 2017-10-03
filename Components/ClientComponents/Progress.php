<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Progress {
    /**
     * @param $fill -- this is string that indicates how far its filled (0.1 = 10%, 1 = 100%)
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'text_content' => 'text string',  // shown
     * 'progress_image'   => 'image_file_name.png', // this is a compound of item id & action of swipe left
     * 'track_image' => 'image_file_name.png', // this must be an object or an array of objects
     * 'track_color' => '#FFFFFF', //
     * 'progress_color' => '#000000',
     * 'animate' => '1' // 0
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
     * 'vertical-align' => 'middle',
     * 'text-align' => 'center',
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

    public function getComponentProgress(string $fill, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->type = 'progress';
        $obj->content = $fill;

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
    }
}
