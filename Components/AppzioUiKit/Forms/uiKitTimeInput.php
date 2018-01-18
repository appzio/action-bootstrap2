<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

use Bootstrap\Components\BootstrapComponent;

trait uiKitTimeInput
{
    public function uiKitTimeInput($params = array())
    {
        /** @var BootstrapComponent $this */
        $image = isset($params['image']) ? $params['image'] : 'clock-outline.png';

        return $this->getComponentRow(array(
            $this->getComponentImage($image, array(), array(
                'width' => '20',
                'margin' => '0 20 0 0'
            )),
            $this->getComponentFormFieldText('', array(
                'hint' => 'hh',
                'variable' => 'time_hour',
                'maxlength' => 2
            ), array(
                'width' => '40',
                'text-align' => 'center',
                'color' => '#777d81',
                'font-weight' => 'bold',
            )),
            $this->getComponentText(':', array(), array(
                'font-weight' => 'bold',
                'color' => '#777d81',
                'margin' => '0 5 0 0',
            )),
            $this->getComponentFormFieldText('', array(
                'hint' => 'mm',
                'variable' => 'time_minutes',
                'maxlength' => 2
            ), array(
                'width' => '40',
                'text-align' => 'center',
                'color' => '#777d81',
                'font-weight' => 'bold',
            ))
        ), array(), array(
            'vertical-align' => 'middle',
            'margin' => '0 0 0 20'
        ));
    }
}