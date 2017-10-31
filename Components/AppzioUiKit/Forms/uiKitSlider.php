<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Models\BootstrapModel;

trait uiKitSlider {

    public function uiKitSlider(array $parameters=array()){

        $max = isset($parameters['max']) ? $parameters['max'] : 20000;
        $min = isset($parameters['min']) ? $parameters['min'] : 50;
        $step = isset($parameters['step']) ? $parameters['step'] : 50;
        $unit = isset($parameters['unit']) ? $parameters['unit'] : '{#km#}';
        $title = isset($parameters['title']) ? $parameters['title'] : '{#distance#}';
        $left_track_color = isset($parameters['left_track_color']) ? $parameters['left_track_color'] : '#ffc204';
        $right_track_color = isset($parameters['left_track_color']) ? $parameters['left_track_color'] : '#bebebe';
        $thumb_color = isset($parameters['thumb_color']) ? $parameters['thumb_color'] : '#7ed321';
        $variable = isset($parameters['variable']) ? $parameters['variable'] : 'filter_distance';
        $variable2 = isset($parameters['variable2']) ? $parameters['variable2'] : false;

        $default_value = isset($parameters['default_value']) ? $parameters['default_value'] : 5000;
        $value = $this->model->getSavedVariable($variable) ? $this->model->getSavedVariable($variable) : $default_value;

        $default_value2 = isset($parameters['default_value2']) ? $parameters['default_value2'] : 5000;
        $value2 = $this->model->getSavedVariable($variable2) ? $this->model->getSavedVariable($variable2) : $default_value2;

        $price[] = $this->getComponentText(strtoupper('{#Distance#}'), array('style' => 'mitems_filter_label'));

        $output[] = $this->uiKitFormSectionHeader($title);

        if(!$variable2) {
            $toprow[] = $this->getComponentText($min . ' ' . $unit, array('style' => 'uikit_slider_left_hint'));
            $indicator[] = $this->getComponentText($value, array('variable' => $variable, 'style' => 'uikit_slider_hint'));
            $indicator[] = $this->getComponentText(' ' . $unit, array('style' => 'uikit_slider_hint'));
            $toprow[] = $this->getComponentRow($indicator, array('style' => 'uikit_slider_indicator'));
            $toprow[] = $this->getComponentText($max . ' ' . $unit, array('style' => 'uikit_slider_right_hint'));
            $output[] = $this->getComponentRow($toprow, array('style' => 'uikit_slider_hintrow'));
        }

        $slider_params = array(
            'min_value' => $min,
            'max_value' => $max,
            'step' => $step,
            'variable' => $variable,
            'left_track_color' => $left_track_color,
            'right_track_color' => $right_track_color,
            'thumb_color' => $thumb_color,
            'track_height' => '4',
            'value' => $value
        );
        if($variable2){
            $slider_params['value2'] = $value2;
            $slider_params['variable2'] = $variable2;
            $slider_params['tooltip_suffix'] = $unit;
            $slider_params['left_track_color'] = $right_track_color;
            $slider_params['right_track_color'] = $left_track_color;

        }

        $slider[] = $this->getComponentRangeSlider($slider_params,array('width' => '100%','margin' => '15 15 15 15'));
        
        $output[] = $this->getComponentRow($slider,array('style' => 'uikit_slider_background'));
        return $this->getComponentColumn($output, array());
    }



}