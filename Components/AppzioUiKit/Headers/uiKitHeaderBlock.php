<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitHeaderBlock {

    public function uiKitHeaderBlock(string $title, $parameters = array(), $content_styles = array(), $styles = array()) {


        if(isset($parameters['vertical-align'])){
            $base_text = [
                'font-size' => '20',
                'text-align' => 'center',
                'margin' => '15 15 15 15',
                'color' => $this->color_top_bar_text_color
            ];

            $base = [
                'background-color' =>$this->color_top_bar_color,
                'vertical-align' => $parameters['vertical-align'],
                'height' => $this->screen_height / 4,
            ];
        } else {
            $base_text = [
                'font-size' => '20',
                'text-align' => 'center',
                'color' => $this->color_top_bar_text_color
            ];

            $base = [
                'background-color' =>$this->color_top_bar_color,
                'vertical-align' => 'middle',
                'height' => $this->screen_height / 4,
            ];
        }


        $styles = array_merge($base, $styles);
        $text_styles = array_merge($base_text, $content_styles);

        return $this->getComponentColumn([
            $this->getComponentText($title, [] , $text_styles)
        ], $parameters, $styles);
    }

}