<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleText {

    public function uiKitArticleText( $params ) {
        return $this->getComponentColumn($this->getParsedContent($params['content']));
    }

}