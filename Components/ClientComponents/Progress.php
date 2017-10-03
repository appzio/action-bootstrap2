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
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
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
