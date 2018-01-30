<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitWideButton
{

    public function uiKitWideButton(string $content, array $params = array())
    {
        /** @var BootstrapComponent $this */
        return $this->getComponentRow(array(
            $this->getComponentText($content, array_merge($params, array('style' => 'uikit_wide_button_text')))
        ), array(
            'style' => 'uikit_wide_button'
        ));
    }

}