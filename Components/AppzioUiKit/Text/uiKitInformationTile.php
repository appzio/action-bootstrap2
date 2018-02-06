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
            $this->uiKitInfoTileIcon($icon),
            $this->uiKitInfoTileTitle($content),
            $this->uiKitInfoTileSubtitle($subtitle)
        ), array(
            'onclick' => $onclick
        ), array_merge(array(
            'background-color' => '#f6f6f6',
            'text-align' => 'center',
            'padding' => '20 10 20 10',
            'width' => '50%',
            'height' => '170',
        ), $style));
    }

    protected function uiKitInfoTileIcon($icon)
    {
        return $this->getComponentImage($icon, array(
            'style' => 'uikit_information_tile_image'
        ));
    }

    protected function uiKitInfoTileTitle($title)
    {
        return $this->getComponentText($title, array(
            'style' => 'uikit_information_tile_title'
        ));
    }

    protected function uiKitInfoTileSubtitle($subtitle)
    {
        return $this->getComponentText($subtitle, array(
            'style' => 'uikit_information_tile_subtitle'
        ));
    }

}