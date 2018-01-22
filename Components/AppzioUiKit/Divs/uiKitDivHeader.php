<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitDivHeader
{
    public function uiKitDivHeader($content = '', $params = array())
    {
        /** @var BootstrapComponent $this */
        return $this->getComponentRow(array(
            $this->getDivHeaderImage(isset($params['image']) ? $params['image'] : ''),
            $this->getComponentText($content, array(
                'style' => 'uikit_div_header_text'
            ))
        ), array(
            'style' => 'uikit_div_header'
        ));
    }

    protected function getDivHeaderImage($image)
    {
        if ($image) {
            return $this->getComponentImage('cloud_upload_dev.png', array(
                'style' => 'uikit_div_header_image'
            ));
        }
    }
}