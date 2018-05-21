<?php

namespace Bootstrap\Components\AppzioUiKit\Chat;

trait uiKitChatMeta {

    public function uiKitChatMeta(string $text, $parameters=array(), $styles=array()){

        $styles = array_merge([
            'color' => '#474747',
            'font-size' => 13,
            'text-align' => 'right',
            'padding' => '5 60 0 0',
        ], $styles);

        return $this->getComponentText($text, $parameters, $styles);
    }

}