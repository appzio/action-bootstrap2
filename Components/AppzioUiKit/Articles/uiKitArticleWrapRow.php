<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleWrapRow {

    public function uiKitArticleWrapRow( $params, $styles = array() ) {

        $styles = array_merge([
            'width' => 'auto',
            'color' => '#676b6f',
            'font-size' => '17',
            'padding' => '10 15 10 15',
        ], $styles);

        return $this->getComponentWrapRow(
            $this->getParsedContent($params['content']),
            $this->getEntryParams($params),
            $styles
        );
    }

}