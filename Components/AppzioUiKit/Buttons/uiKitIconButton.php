<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitIconButton
{

    public function uiKitIconButton(string $content, $params = array(), $styles = array())
    {
        /** @var BootstrapComponent $this */

        $icon = isset($params['icon']) ? $params['icon'] : '';

        return $this->getComponentRow(array(
//            $this->getIconButtonImage($icon),
            $this->getComponentText($content, array(), array(
                'color' => '#D40511',
            ))
        ), $params, array_merge(array(
            'margin' => '0 25 15 25',
            'border-color' => '#9b9b9b',
            'border-radius' => '20',
            'padding' => '12 0 12 0',
            'text-align' => 'center',
        ), $styles));
    }

    public function getIconButtonImage(string $icon)
    {
        if (empty($icon)) {
            return;
        }

        return $this->getComponentImage($icon, array(), array(
            'width' => '20',
            'margin' => '0 10 0 0'
        ));
    }

}