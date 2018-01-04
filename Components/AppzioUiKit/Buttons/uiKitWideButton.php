<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitWideButton
{

    public function uiKitWideButton(string $content, array $params = array())
    {
        /** @var BootstrapComponent $this */
        return $this->getComponentRow(array(
            $this->getComponentText($content, array(
                'onclick' => isset($params['onclick']) ? $params['onclick'] : new \stdClass()
            ), array(
                'color' => '#323232',
//                'border-color' => '#9b9b9b',
                'border-radius' => '25',
                'width' => '75%',
                'height' => '50',
                'text-align' => 'center',
                'font-ios' => 'OpenSans',
                'font-android' => 'OpenSans',
                'use_clipping' => '0',
                'background-color' => '#FFCC00'
            ))
        ), array(), array(
            'text-align' => 'center',
            'vertical-align' => 'middle',
            'margin' => '0 0 15 0'
        ));
    }

}