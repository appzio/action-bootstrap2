<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitWideButton
{

    public function uiKitWideButton(string $content, array $params = array(), $styles = array())
    {
        /** @var BootstrapComponent $this */
        return $this->getComponentRow(array(
            $this->getComponentText($content, array(), array_merge(
                array('parent_style' => 'uikit_wide_button_text'),
                $styles
            ))
        ), array_merge(
            array('style' => 'uikit_wide_button'),
            $params
        ));
    }

}