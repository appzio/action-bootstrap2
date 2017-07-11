<?php

namespace packages\actionMexample\Components;
use Bootstrap\Components\BootstrapComponent;

trait getPhotoField {

    /**
     * @param $content string, no support for line feeds
     * @param array $styles 'margin', 'padding', 'orientation', 'background', 'alignment', 'radius', 'opacity',
     * 'orientation', 'height', 'width', 'align', 'crop', 'text-style', 'font-size', 'text-color', 'border-color',
     * 'border-width', 'font-android', 'font-ios', 'background-color', 'background-image', 'background-size',
     * 'color', 'shadow-color', 'shadow-offset', 'shadow-radius', 'vertical-align', 'border-radius', 'text-align',
     * 'lazy', 'floating' (1), 'float' (right | left), 'max-height', 'white-space' (no-wrap), parent_style
     * @param array $parameters selected_state, variable, onclick, style
     * @return \stdClass
     */

    public function getPhotoField(string $content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        if($this->model->getSavedVariable('profilepic')){
            $pic = $this->model->getSavedVariable('profilepic');
        } else {
            $pic = 'icon_camera-grey.png';
        }

        $obj[] = $this->getComponentImage($pic,array(
            'style' => 'mreg_pic',
            'variable' => $this->model->getVariableId('profilepic'),
            'onclick' => $this->getOnclickImageUpload('profilepic',array('max_dimensions' => '900'))
        ));

        //$obj[] = $this->getComponentText('Hello');

        $row[] = $this->getComponentRow($obj,array(
            'style' => 'mreg_picshadow'
        ));

        return $this->getComponentRow($row,array('style' => 'mreg_picrow'));

	}

}