<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitRemoveUserDiv
{
    public function uiKitRemoveUserDiv(array $params=array())
    {

        $text = isset($params['text']) ? $params['text'] : '{#are_you_sure_you_want_to_remove_this_item_from_liked?#}';

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
                    $this->getOnclickSubmit('Controller/removeuser/thisuser',['sync_open' => 1]),
                    $this->getOnclickLogout()
                )
            ))
        ), array(
            'style' => 'uikit_div'
        ));
    }
}