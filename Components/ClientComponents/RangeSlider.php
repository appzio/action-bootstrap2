<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait RangeSlider
 * @package Bootstrap\Components\Elements
 */
trait RangeSlider {
    /**
     * @variable -- variable name
     * @min_value -- numeric minimum value
     * @max_value -- numeric maximum value
     * @step -- numeric resolution of the steps in the slider
     * @param $fill -- this is string that indicates how far its filled (0.1 = 10%, 1 = 100%)
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
