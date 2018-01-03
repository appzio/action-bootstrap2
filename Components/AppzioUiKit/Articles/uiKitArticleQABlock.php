<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleQABlock {

    public function uiKitArticleQABlock( $params ){
        return $this->getComponentText(strtoupper($params['question']) . ': ' . $params['answer'], array(
	        'style' => 'article-uikit-text'
        ));
    }

}