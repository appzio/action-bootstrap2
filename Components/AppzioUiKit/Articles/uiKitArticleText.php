<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleText {

    public function uiKitArticleText( $params ) {
        return $this->getComponentText($params['content'], array(
        	'style' => 'article-uikit-text'
        ));
    }

}