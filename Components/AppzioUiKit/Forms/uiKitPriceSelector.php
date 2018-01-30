<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

use Bootstrap\Components\BootstrapComponent;

trait uiKitPriceSelector {

    public function uiKitPriceSelector(array $parameters=array()){

	    /** @var BootstrapComponent $this */

        $price[] = $this->getComponentText(strtoupper('{#Distance#}'), array(
            'style' => 'mitems_filter_label'
        ));

        $distance = $this->model->getSavedVariable('filter_distance');
        $distanceValue = empty($distance) ? 5000 : $distance;

        $price[] = $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentText('0 {#km#}',array(), array(
                    'width' => '33%',
                    'font-size' => '14',
                    'color' => "#FFFFFF"
                )),
                $this->getComponentRow(array(
                    $this->getComponentText($distanceValue, array('variable' => 'filter_distance'), array(
                        'font-size' => '15',
                        'color' => "#FFFFFF"
                    )),
                    $this->getComponentText( ' {#km#}', array(), array(
                        'font-size' => '15',
                        'color' => "#FFFFFF"
                    )),
                ), array(), array(
                    'width' => '33%',
                    'text-align' => 'center',
                )),
                $this->getComponentText('20.000 {#km#}', array(), array(
                    'width' => '33%',
                    'text-align' => 'right',
                    'font-size' => '14',
                    'color' => "#FFFFFF"
                ))
            ), array(), array(
                'margin' => '12 20 0 20',
            )),
            $this->getComponentRangeSlider(array_merge(
                array(
                    'min_value' => 50,
                    'max_value' => 20000,
                    'step' => 50,
                    'variable' => 'filter_distance',
                    'value' => $distanceValue,
                ),
                $this->getSliderStyles()
            ))
        ), array(), array(
            'background-color' => '#2d2d2d',
        ));

        return $this->getComponentColumn($price, array(), array(
            'padding' => '10 20 0 20'
        ));
    }

}