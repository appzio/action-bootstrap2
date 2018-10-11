<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

trait uiKitDividerError {

    public function uiKitDividerError(){
        return $this->getComponentText('', array('style'  => 'uikit_divider_error'));
    }

}