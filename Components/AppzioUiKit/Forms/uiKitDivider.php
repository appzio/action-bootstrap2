<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

trait uiKitDivider {

    public function uiKitDivider(){
        return $this->getComponentText('', array('style'  => 'uikit_divider'));
    }

}