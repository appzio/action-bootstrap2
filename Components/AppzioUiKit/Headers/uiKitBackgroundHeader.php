<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitBackgroundHeader {

    /**
     * Renders uikit header with background
     * @param string $text
     * @return object
     */
    public function uiKitBackgroundHeader(string $text, $parameters = array(), $styles = array()){
        return $this->getComponentText($text, $parameters, array_merge(
            array(
                'color' => '#000000',
                'font-size' => '16',
                'font-weight' => 'bold',
                'width' => '100%',
                'padding' => '10 15 10 15',
                'margin' => '0 0 10 0',
                'background-color' => '#f9f9f9'
            ),
            $styles
        ));
    }

}