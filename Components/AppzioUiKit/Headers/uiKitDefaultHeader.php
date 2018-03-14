<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitDefaultHeader {

    /**
     * Renders uikit default header
     * @param string $text
     * @return object
     */
    public function uiKitDefaultHeader(string $text, $parameters = array(), $styles = array()){
        return $this->getComponentText($text, $parameters, array_merge(
            array(
                'font-size' => '16',
                'margin' => '5 15 5 15',
                'vertical-align' => 'middle',
            ),
            $styles
        ));
    }

}