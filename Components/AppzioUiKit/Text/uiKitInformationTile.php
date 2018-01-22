<?php

namespace Bootstrap\Components\AppzioUiKit\Text;

trait uiKitInformationTile
{

    public function uiKitInformationTile($content = '', $params = array(), $style = array())
    {
        $icon = isset($params['icon']) ? $params['icon'] : null;
        $subtitle = isset($params['subtitle']) ? $params['subtitle'] : null;
        $onclick = isset($params['onclick']) ? $params['onclick'] : null;

        return $this->getComponentColumn(array(
            $this->getTileIcon($icon),
            $this->getTileTitle($content),
            $this->getTileSubtitle($subtitle)
        ), array(
            'onclick' => $onclick
        ), array_merge(array(
            'background-color' => '#f6f6f6',
            'text-align' => 'center',
            'padding' => '20 10 20 10',
            'margin' => '10 5 10 5',
            'height' => '170',
            'width' => '170'
        ), $style));
    }

    protected function getTileIcon($icon)
    {
        return $this->getComponentImage($icon, array(), array(
            'width' => 40,
            'margin' => '0 0 20 0'
        ));
    }

    protected function getTileTitle($title)
    {
        return $this->getComponentText($title, array(), array(
            'text-align' => 'center',
            'font-weight' => 'bold',
            'font-size' => 24,
            'margin' => '0 0 10 0'
        ));
    }

    protected function getTileSubtitle($subtitle)
    {
        return $this->getComponentText($subtitle, array(), array(
            'text-align' => 'center',
            'color' => '#969a9d',
            'font-size' => '14'
        ));
    }
}