<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitBlockButtonsDiv
{
    public $isLiked;

    public function uiKitBlockButtonsDiv($params = array())
    {
        /** @var BootstrapComponent $this */
        $this->addDivs(array(
            'uikit-report-item' => 'uiKitReportItemDiv',
            'uikit-remove-item' => 'uiKitRemoveItemDiv'
        ));

        $buttons = array();

        $buttons[] = $this->getActiveBlockButton('{#report#}', 'uikit-report-item');

        $buttons[] = $this->getComponentDivider();

        $buttons[] = $this->isLiked ?
            $this->getActiveBlockButton('{#remove_from_liked#}', 'uikit-remove-item') :
            $this->getDisabledBlockButton('{#remove_from_liked#}');

        return $this->getComponentColumn($buttons, array(
            'style' => 'uikit_block_btn_div'
        ));
    }

    protected function getActiveBlockButton($text, $divId)
    {
        $layout = new \stdClass();
        $layout->top = 100;
        $layout->right = 10;
        $layout->left = 10;

        return $this->getComponentText($text, array(
            'onclick' => $this->getOnclickShowDiv($divId, array(
                'tap_to_close' => '1',
                'background' => 'blur',
                'transition' => 'from-bottom',
                'layout' => $layout
            )),
            'style' => 'uikit_block_btn_div_item_active'
        ));
    }

    protected function getDisabledBlockButton($text)
    {
        return $this->getComponentText($text, array(
            'style' => 'uikit_block_btn_div_item_disabled'
        ));
    }
}