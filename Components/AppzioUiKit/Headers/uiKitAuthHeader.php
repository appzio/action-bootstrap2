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
            'style' => 'uikit_auth_header'
        ));
    }

    protected function getHeaderImage($image)
    {
        /** @var BootstrapComponent $this */

        if (!$image) {
            return;
        }

        return $this->getComponentImage($image, array(
            'style' => 'uikit_auth_header_image'
        ));
    }

    protected function getHeaderText($text)
    {
        /** @var BootstrapComponent $this */

        if (!$text) {
            return;
        }

        return $this->getComponentText($text, array(
            'style' => 'uikit_auth_header_text'
        ));
    }
}