<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitHeaderBlock {

    public function uiKitHeaderBlock(string $title, $parameters = array(), $content_styles = array(), $styles = array()) {

        $base_text = [
            'font-size' => '20',
            'text-align' => 'center',
        ];

        $base = [
            'background-color' => '#F6F6F6',
            'vertical-align' => 'middle',
            'height' => $this->screen_height / 4,
        ];

        $styles = array_merge($base, $styles);
        $text_styles = array_merge($base_text, $content_styles);

        return $this->getComponentColumn([
            $this->getComponentText($title, [] , $text_styles)
        ], $parameters, $styles);
    }

}