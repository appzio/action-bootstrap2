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
        } else {
            $col[] = $this->getComponentImage('uikit_photo_upload_blue.png',
                ['priority' => '9','onclick' => $onclick,'variable' => 'profilepic'],['width' => '100','crop' => 'round']);
        }


        $out[] = $this->getComponentColumn($col,[],['margin' => '20 15 5 15', 'text-align' => 'center']);
        $row[] = $this->getPhotoUploadButtonUiKit($vars, 2);
        $row[] = $this->getPhotoUploadButtonUiKit($vars, 3);
        $row[] = $this->getPhotoUploadButtonUiKit($vars, 4);
        $row[] = $this->getPhotoUploadButtonUiKit($vars, 5);
        $row[] = $this->getPhotoUploadButtonUiKit($vars, 6);
        $out[] = $this->getComponentRow($row,[],['margin' => '10 15 25 5', 'text-align' => 'center']);



        //uikit_photo_upload_blue.png

        return $this->getComponentColumn($out);

    }


    public function getPhotoUploadButtonUiKit($vars,$num){

        $varname = 'profilepic'.$num;

        $onclick = $this->getOnclickImageUpload($varname,array(
            'max_dimensions' => '600',
            'sync_upload' => 1
        ));

        $width = round(($this->screen_width - 90) / 5,0);

        if(isset($vars[$varname]) AND $vars[$varname]){
            return $this->getComponentImage($vars[$varname],
                ['priority' => '9','onclick' => $onclick,'variable' => $varname],[
                    'width' =>$width,'crop' => 'round','margin' => '0 0 0 10']);
        } else {
            return $this->getComponentImage('uikit_photo_upload_blue.png',
                ['priority' => '9','onclick' => $onclick,'variable' => $varname],['width' => $width,'crop' => 'round','margin' => '0 0 0 10']);
        }

    }


}