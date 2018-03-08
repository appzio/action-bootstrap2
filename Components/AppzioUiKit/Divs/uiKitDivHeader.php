<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitDivHeader
{

    public function uiKitDivHeader($content = '', $params = array())
    {
        /** @var BootstrapComponent $this */

        if ( isset($params['image']) AND $params['image'] ) {
            $output[] = $this->getDivHeaderImage($params['image']);
        }

        $output[] = $this->getComponentText($content, array(
            'style' => 'uikit_div_header_text'
        ));

        if ( isset($params['close_icon']) AND $params['close_icon'] ) {
            $output[] = $this->getDivCloseButton(
                $params['close_icon'],
                isset($params['div_id']) ? $params['div_id'] : ''
            );
        }

        return $this->getComponentRow($output, array(
            'style' => 'uikit_div_header'
        ));
    }

    protected function getDivHeaderImage($image)
    {
        return $this->getComponentImage($image, array(
            'style' => 'uikit_div_header_image'
        ));
    }

    protected function getDivCloseButton($image, $divId)
    {
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