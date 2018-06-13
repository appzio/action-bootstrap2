<?php

namespace Bootstrap\Components\AppzioUiKit\Controls;
use Bootstrap\Views\BootstrapView;

trait uiKitOpenProfile {


    public function uiKitOpenProfile($id){

        return $this->getOnclickOpenAction(
            'userinfo',
            false,
            array('sync_open' => 1, 'back_button' => 1, 'id' => $id)
        );

    }


}