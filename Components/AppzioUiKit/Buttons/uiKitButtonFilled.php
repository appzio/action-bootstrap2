<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

trait uiKitButtonFilled {


    /**
     * Renders default UIkit button, takes default color from app / branch or action.
     * @param $title
     * @param array $parameters
     * @param array $styles
     * @return mixed
     */

    public function uiKitButtonFilled($title, $parameters=array(), $styles=array()){
        $style['parent_style'] = 'uikit_default_btn';
        $style['background-color'] = isset($styles['background-color']) ? $styles['background-color'] : $this->colors['button_color'];
        $style['color'] = isset($styles['color']) ? $styles['color'] : $this->colors['button_text_color'];
        $style['margin'] = isset($styles['margin']) ? $styles['margin'] : '0 80 0 80';
        $styles = array_merge($styles,$style);
        return $this->getComponentText($title,$parameters,$styles);
    }


}