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
            $output[] = $this->getDivCloseButton($params['close_icon']);
        }

        $header_params = [
            'style' => 'uikit_div_header'
        ];

        if ( isset($params['div_id']) AND $params['div_id'] ) {
            $header_params['onclick'] = $this->getOnclickHideDiv($params['div_id']);
        }

        return $this->getComponentRow($output, $header_params);
    }

    protected function getDivHeaderImage($image)
    {
        return $this->getComponentImage($image, array(
            'style' => 'uikit_div_header_image'
        ));
    }

    protected function getDivCloseButton($image)
    {
        return $this->getComponentImage($image, array(), array(
            'width' => '15',
            'floating' => '1',
            'float' => 'right',
            'margin' => '2 0 0 0'
        ));
    }

}