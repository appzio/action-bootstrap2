<?php

namespace Bootstrap\Components\AppzioUiKit\Controls;
use Bootstrap\Views\BootstrapView;

trait uikitUserPhotoUploader {


    public function uikitUserPhotoUploader($vars){

        $onclick = $this->getOnclickImageUpload('profilepic',array(
            'max_dimensions' => '600',
            'sync_upload' => 1
        ));

        if(isset($vars['profilepic']) AND $vars['profilepic']){
            $col[] = $this->getComponentImage($vars['profilepic'],
                ['priority' => '9','onclick' => $onclick,'variable' => 'profilepic'],['width' => '100','crop' => 'round']);
        }

        return $this->getComponentColumn($col,[],['margin' => '20 15 15 15', 'text-align' => 'center']);

    }


}