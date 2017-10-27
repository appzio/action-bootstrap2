<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitButtonBlock
{
    public $isLiked;

    public function uiKitButtonBlock($params = array())
    {
        /** @var BootstrapComponent $this */
        $this->isLiked = isset($params['isLiked']) && !empty($params['isLiked']) ? true : false;

        $this->addDivs(array('uikit-block-buttons' => 'uiKitBlockButtonsDiv'));

        $layout = new \stdClass();
        $layout->top = $this->screen_height / 12;
        $layout->right = $this->screen_width / 8;

        $onclick = $this->getOnclickShowDiv('uikit-block-buttons', array(
            'tap_to_close' => 1,
            'transition' => 'fade',
            'layout' => $layout
        ));

        return $this->getComponentRow(array(
            $this->getComponentImage('block-icon.png', array(
                'onclick' => $onclick,
                'style' => 'uikit_block_btn_icon'
            ))
        ), array(), array(
            'vertical-align' => 'middle'
//            'margin' => '-' . $this->screen_height / 2.7 . ' 0 ' . $this->screen_height / 3.1 . ' 0',
//            'padding' => '0 20 0 20',
//            'margin' => '-' . round($this->screen_width / 1.45, 0) . ' 0 ' . round($this->screen_width / 1.6, 0) . ' 0'
        ));
    }
}