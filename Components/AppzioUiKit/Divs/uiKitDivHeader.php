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
            )),
            $this->getDivCloseButton(
                isset($params['close_icon']) ? $params['close_icon'] : '',
                isset($params['div_id']) ? $params['div_id'] : ''
            )
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

    protected function getDivCloseButton($image, $divId)
    {
        if ($image) {
            return $this->getComponentImage($image, array(
                'onclick' => $this->getOnclickHideDiv($divId)
            ), array(
                'width' => '15',
                'floating' => '1',
                'float' => 'right',
                'margin' => '2 0 0 0'
            ));
        }
    }
}