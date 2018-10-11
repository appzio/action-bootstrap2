<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

trait uiKitFormErrorText {

    public function uiKitFormErrorText($errortext){
        return $this->getComponentText($errortext, array('style'  => 'uikit_form_error_text'));
    }

}