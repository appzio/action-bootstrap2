<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait RangeSlider {
    /**
     * @variable -- variable name
     * @min_value -- numeric minimum value
     * @max_value -- numeric maximum value
     * @step -- numeric resolution of the steps in the slider
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'variable' => 'variable', // !!! REQUIRED
     * 'min_value' => 1, // !!! REQUIRED
     * 'max_value' => 10, // !!! REQUIRED
     * 'step' => 1, // !!! REQUIRED
     * 'left_track_color' => '#FFFFFF',  // shown
     * 'right_track_color'   => '#FFFFFF', // this is a compound of item id & action of swipe left
     * 'thumb_color' => '#000000', // this must be an object or an array of objects
     * 'thumb_image' => 'imagefilename.png', //
     * 'track_height' => '40',
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */

    public function getComponentRangeSlider(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->type = 'slider';

        $required = array('variable','min_value','max_value','step');
        $allowed = array('left_track_color','right_track_color','thumb_color','thumb_image','track_height');

        //print_r($allowed);
        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters,$allowed,$required);
        $obj = $this->configureDefaults($obj);

        return $obj;
    }

}
