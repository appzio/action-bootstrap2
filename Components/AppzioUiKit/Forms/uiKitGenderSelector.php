<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

trait uiKitGenderSelector {

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

    public function uiKitGenderSelector(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        $row[] = $this->uiKitGetGenderButton('female');
        $row[] = $this->uiKitGetGenderButton('male');

        return $this->getComponentRow($row,array('style' => 'mreg_picrow'));
    }

    private function uiKitGetGenderButton($gender='female'){

        $selected = $this->getImageFileName('uikit-icon-' . $gender.'-selected.png');
        $unselected = $this->getImageFileName('uikit-icon-' . $gender.'.png');

        $selectstate = array(
            'style_content' => $this->uikitGetBtnStyleForGenderSelector($selected),
            'variable_value' => $gender,
            'allow_unselect' => 1,
            'variable' => 'gender',
            'animation' => 'fade'
        );

        if($this->model->getSubmittedVariableByName('gender') == $gender OR $this->model->getSavedVariable('gender') == $gender){
            $selectstate['active'] = '1';
        } else {
            $selectstate['active'] = false;
        }

        $gender_text = ( $gender == 'female' ? '{#female#}' : '{#male#}' );

        return $this->getComponentColumn([
            $this->getComponentText('', array(
                'variable' => 'gender',
                'variable_value' => $gender,
                'style_content' => $this->uikitGetBtnStyleForGenderSelector($unselected),
                'allow_unselect' => 1,
                'selected_state' => $selectstate,
            )),
            $this->getComponentText($gender_text, [], [
                'padding' => '8 0 0 0',
                'color' => '#B2B4B3',
                'text-align' => 'center',
            ]),
        ]);
    }

    private function uikitGetBtnStyleForGenderSelector($bg){
        $style = new \stdClass();
        $style->width = '60';
        $style->height = '60';
        $field_name = 'background-image';
        $style->$field_name = $bg;
        $field_name = 'background-size';
        $style->$field_name = 'cover';
        $style->margin = '0 20 0 20';
        return $style;
    }

}