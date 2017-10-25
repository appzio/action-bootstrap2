<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

trait uiKitDoubleButtons {

    /**
     * Returns a formkit double buttons for bottom of the view.
     * Includes spacing before and after and sets a background color.
     * @param string $btn1_title
     * btn1 = solid color
     * @param string $btn2_title
     * btn2 = hollow button
     * @param array $btn1_parameters
     * Standard text element parameters
     * @param array $btn2_parameters
     * Standard text element parameters
     * @param array $btn1_styles
     * Standard text element styles
     * @param array $btn2_styles
     * Standard text element styles
     * @param string $background
     * Background color for the area
     * @return mixed
     */

    public function uiKitDoubleButtons(string $btn1_title, string $btn2_title, $btn1_parameters=array(), $btn2_parameters=array(), $btn1_styles=array(), $btn2_styles=array(), $background='#ffffff'){
        $out[] = $this->getComponentSpacer('20');
        $out[] = $this->uiKitButtonFilled($btn1_title);
        $out[] = $this->getComponentSpacer('10');
        $out[] = $this->uiKitButtonHollow($btn2_title);
        $out[] = $this->getComponentSpacer('20');

        return $this->getComponentColumn($out, array(), array(
            'background-color' => $background
        ));

    }
    


}