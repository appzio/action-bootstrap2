<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;
use Bootstrap\Components\BootstrapComponent;

trait uiKitAuthHeader
{
    public function uiKitAuthHeader(string $image, string $text, $parameters = array(), $styles = array())
    {
        /** @var BootstrapComponent $this */
        return $this->getComponentRow(array(
            $this->getHeaderImage($image),
            $this->getHeaderText($text)
        ));
    }

    protected function getHeaderImage($image)
    {
        /** @var BootstrapComponent $this */

        if (!$image) {
            return;
        }

        return $this->getComponentImage($image);
    }

    protected function getHeaderText($text)
    {
        /** @var BootstrapComponent $this */

        if (!$text) {
            return;
        }

        return $this->getComponentText($text);
    }
}