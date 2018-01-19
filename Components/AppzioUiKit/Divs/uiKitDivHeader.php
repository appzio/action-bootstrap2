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
            $this->getComponentText($content, array(), array(
                'color' => '#ffffff',
                'font-size' => '14',
                'width' => '100%',
            ))
        ), array(), array(
            'padding' => '10 20 10 20',
            'background-color' => '#4a4a4a',
            'shadow-color' => '#33000000',
            'shadow-radius' => '1',
            'shadow-offset' => '0 3',
            'margin' => '0 0 20 0'
        ));
    }

    protected function getDivHeaderImage($image)
    {
        if (!$image) {
            return;
        }

        return $this->getComponentImage('cloud_upload_dev.png', array(), array(
            'width' => '20',
            'margin' => '0 10 0 0'
        ));
    }
}