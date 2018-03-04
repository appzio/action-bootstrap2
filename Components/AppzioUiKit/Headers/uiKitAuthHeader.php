<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;
use Bootstrap\Components\BootstrapComponent;

trait uiKitAuthHeader
{
    public function uiKitAuthHeader(string $image, string $text, $params = array(), $styles = array())
    {

        /** @var BootstrapComponent $this */
        return $this->getComponentRow(array(
            $this->getHeaderImage($image),
            $this->getHeaderText($text)
        ), array(
            'parent_style' => 'uikit_auth_header'
        ),array(
            'background-color' => $this->color_top_bar_color,
            'text-align' => 'center'
        ));
    }

    protected function getHeaderImage($image)
    {
        /** @var BootstrapComponent $this */

        if (!$image) {
            return;
        }

        return $this->getComponentImage($image, array(
            'parent_style' => 'uikit_auth_header_image'
        ),array(
            'background-color' => $this->color_top_bar_color,
        ));
    }

    protected function getHeaderText($text)
    {
        /** @var BootstrapComponent $this */

        return $this->getComponentText($text, array(
            'parent_style' => 'uikit_auth_header_text'
        ),array(
            'background-color' => $this->color_top_bar_color,
        ));
    }
}