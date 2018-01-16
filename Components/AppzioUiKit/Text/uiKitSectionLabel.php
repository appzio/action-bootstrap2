<?php

namespace Bootstrap\Components\AppzioUiKit\Text;

trait uiKitSectionLabel
{

    public function uiKitSectionLabel($content = '', $params = array(), $style = array())
    {
        return $this->getComponentText($content, array(), array(
            'font-size' => '14',
            'background-color' => '#f9f9f9',
            'color' => '#2c2b2b',
            'padding' => '20 0 20 20',
            'border-color' => '#e3e3e3',
            'border-width' => '1'
        ));
    }
}