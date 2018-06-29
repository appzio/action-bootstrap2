<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleRichText {

    public function uiKitArticleRichText( $params, $styles = array() ) {

        $styles = array_merge([
            'width' => 'auto',
            'color' => '#676b6f',
            'font-size' => '17',
            'padding' => '10 15 10 15',
        ], $styles);

        return $this->getComponentRichText($this->getParsedContent($params['content']), [], $styles);
    }

}