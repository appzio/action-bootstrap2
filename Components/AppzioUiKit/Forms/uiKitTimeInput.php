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
	        $this->getComponentRow(array(
		        $this->getComponentFormFieldText('', array(
			        'hint' => 'hh',
			        'variable' => 'time_hour',
			        'maxlength' => 2
		        ), array(
			        'width' => '50',
			        'color' => '#777d81',
			        'font-weight' => 'bold',
		        )),
		        $this->getComponentText(':', array(), array(
			        'font-weight' => 'bold',
			        'color' => '#777d81',
			        'margin' => '0 3 0 3',
		        )),
		        $this->getComponentFormFieldText('', array(
			        'hint' => 'mm',
			        'variable' => 'time_minutes',
			        'maxlength' => 2
		        ), array(
			        'width' => '60',
			        'color' => '#777d81',
			        'font-weight' => 'bold',
		        ))
	        ), array(), array(
	        	'width' => 'auto',
	        )),
        ), array(), array(
            'vertical-align' => 'middle',
            'margin' => '0 0 0 20'
        ));
    }

}