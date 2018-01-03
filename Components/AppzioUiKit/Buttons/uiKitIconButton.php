<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitIconButton
{

    public function uiKitIconButton(string $content, $params = array(), $styles = array())
    {
        /** @var BootstrapComponent $this */

        return $this->getComponentRow(array(
            $this->getComponentText($content, $params, array(
                'color' => '#5a3a3a',
                'border-color' => '#9b9b9b',
                'border-radius' => '25',
                'width' => '75%',
                'padding' => '12 0 12 0',
                'text-align' => 'center',
                'font-ios' => 'OpenSans',
                'font-android' => 'OpenSans'
            ))
        ), array(), array(
            'text-align' => 'center',
            'margin' => '0 0 15 0'
        ));
    }

}