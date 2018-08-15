<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitBlockItemDiv
{
    public function uiKitRemoveItemDiv(array $params=array())
    {

        $text = isset($params['text']) ? $params['text'] : '{#are_you_sure_you_want_to_block_this_user?#}';

        /** @var BootstrapComponent $this */
        return $this->getComponentColumn(array(
            $this->getComponentText('Are you sure?', array(
                'style' => 'uikit_div_title'
            )),
            $this->getComponentText(ucfirst($text), array(
                'style' => 'uikit_div_body'
            )),
            $this->getComponentText('Remove', array(
                'style' => 'uikit_div_button',
                'onclick' => array(
                    $this->getOnclickSubmit('Controller/block'),
                    $this->getOnclickHideDiv('uikit-remove-item'),
                    $this->getOnclickHideDiv('uikit-block-buttons'),
                    $this->getOnclickGoHome()
                )
            ))
        ), array(
            'style' => 'uikit_div'
        ));
    }
}