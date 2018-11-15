<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

use Bootstrap\Components\BootstrapComponent;

trait uiKitTwoHandSlider {

    public function uiKitTwoHandSlider(array $parameters=array()){
	    /** @var BootstrapComponent $this */

        $max = isset($parameters['max']) ? $parameters['max'] : 20000;
        $min = isset($parameters['min']) ? $parameters['min'] : 0;
        $step = isset($parameters['step']) ? $parameters['step'] : 50;
        $unit = isset($parameters['unit']) ? $parameters['unit'] : '{#km#}';
        $title = isset($parameters['title']) ? $parameters['title'] : '{#distance#}';
        $left_track_color = isset($parameters['left_track_color']) ? $parameters['left_track_color'] : $this->color_top_bar_color;
        $right_track_color = isset($parameters['left_track_color']) ? $parameters['left_track_color'] : '#bebebe';
        $thumb_color = isset($parameters['thumb_color']) ? $parameters['thumb_color'] : '#7ed321';
        $variable = isset($parameters['variable']) ? $parameters['variable'] : 'distance_min';
        $variable2 = isset($parameters['variable2']) ? $parameters['variable2'] : 'distance_max';
        $value = isset($parameters['value']) ? $parameters['value'] : 0;
        $value2 = isset($parameters['value2']) ? $parameters['value2'] : 20000;

        $output[] = $this->uiKitFormSectionHeader($title);

        $toprow[] = $this->getComponentText($min.' '.$unit,array('style' => 'uikit_slider_left_hint'));
        $indicator[] = $this->getComponentText('', array('style' => 'uikit_slider_hint'));
        $indicator[] = $this->getComponentText('', array('style' => 'uikit_slider_hint'));
        $toprow[] = $this->getComponentRow($indicator,array('style' => 'uikit_slider_indicator'));
        $toprow[] = $this->getComponentText($max.' '.$unit, array('style' => 'uikit_slider_right_hint'));

        $output[] = $this->getComponentRow($toprow,array('style' => 'uikit_slider_hintrow'));


        $slider[] = $this->getComponentRangeSlider(
            array(
                'min_value' => $min,
                'max_value' => $max,
                'step' => $step,
                'variable' => $variable,
                'variable2' => $variable2,
                'value' => $value,
                'value2' => $value2,
                'left_track_color' => $left_track_color,
                'right_track_color' => $right_track_color,
                'thumb_color' => $thumb_color,
                'track_height' => '4'
            ),array('width' => '100%','margin' => '15 15 15 15'));
        
        $output[] = $this->getComponentRow($slider,array('style' => 'uikit_slider_background'));
        return $this->getComponentColumn($output, array());
    }

}