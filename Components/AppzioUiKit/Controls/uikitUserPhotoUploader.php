<?php

namespace Bootstrap\Components\AppzioUiKit\Controls;
use Bootstrap\Components\BootstrapComponent;
use Bootstrap\Views\BootstrapView;

trait uikitUserPhotoUploader {


    public function uikitUserPhotoUploader($vars,$extra_images=array()){
        /** @var BootstrapComponent $this */

/*        $this->addDivs(array(
            'uikit-report-item' => 'uiKitReportItemDiv',
            'uikit-remove-item' => 'uiKitRemoveItemDiv'
        ));*/


        if($extra_images){
            $onclick[] = $this->getOnclickShowElement('image_gallery');
            $onclick[] = $this->getOnclickSubmit('Controller/setactiveimage/default');

            if(isset($vars['profilepic']) AND $vars['profilepic']){
                $col[] = $this->getComponentImage($vars['profilepic'],
                    ['priority' => '9','onclick' => $onclick,'variable' => 'profilepic'],['width' => '100','crop' => 'round']);
            } else {
                $col[] = $this->getComponentImage('uikit_photo_upload_blue.png',
                    ['priority' => '9','onclick' => $onclick,'variable' => 'profilepic'],['width' => '100','crop' => 'round']);
            }

            $out[] = $this->getComponentColumn($col,[],['margin' => '20 15 5 15', 'text-align' => 'center']);

            $row[] = $this->getPhotoUploadButtonUiKitExtraImages($vars, 2,$extra_images);
            $row[] = $this->getPhotoUploadButtonUiKitExtraImages($vars, 3,$extra_images);
            $row[] = $this->getPhotoUploadButtonUiKitExtraImages($vars, 4,$extra_images);
            $row[] = $this->getPhotoUploadButtonUiKitExtraImages($vars, 5,$extra_images);
            $row[] = $this->getPhotoUploadButtonUiKitExtraImages($vars, 6,$extra_images);

        } else {

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
        }
        $out[] = $this->getComponentRow($row,[],['margin' => '10 15 25 5', 'text-align' => 'center']);

        if($extra_images){
            $out[] = $this->uikitGetGalleryButtons(2);
            $out[] = $this->uikitGetGalleryButtons(3);
            $out[] = $this->uikitGetGalleryButtons(4);
            $out[] = $this->uikitGetGalleryButtons(5);
            $out[] = $this->uikitGetGalleryButtons(6);
            $out[] = $this->uiKitImageGallery($extra_images);
        }

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

    public function getPhotoUploadButtonUiKitExtraImages($vars,$num,$extra_images){
        $varname = 'profilepic'.$num;

/*        $onclick = $this->getOnclickImageUpload($varname,array(
            'max_dimensions' => '600',
            'sync_upload' => 1
        ));*/

        $onclick[] = $this->getOnclickShowElement('buttons_'.$num);
        $onclick[] = $this->getOnclickShowElement('image_gallery');
        $onclick[] = $this->getOnclickSubmit('controller/setactiveimage/'.$num,['loader_off' => true]);

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

    public function uikitGetGalleryButtons($id){

        $onclick[] = $this->getOnclickHideElement('image_gallery',['viewport' => 'top']);
        $onclick[] = $this->getOnclickHideElement('buttons_'.$id,['viewport' => 'top']);

        $imgupload = $this->getOnclickImageUpload('profilepic'.$id);

        $col[] = $this->getComponentText('{#upload_image#}',['style' => 'uikit_list_follow_button','onclick' => $imgupload]);
        $col[] = $this->getComponentText('{#close#}',['style' => 'uikit_list_hide_button_no_margin',
            'onclick' => $onclick]);

        return $this->getComponentRow($col,['visibility' => 'hidden', 'id' => 'buttons_'.$id],['width' => '100%',
            'margin' => '0 30 0 30']);

    }


}