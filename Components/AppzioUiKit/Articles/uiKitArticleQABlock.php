<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleQABlock {

    public function uiKitArticleQABlock( $params, $styles = array() ){
        return $this->getComponentText(strtoupper($params['question']) . ': ' . $params['answer'], array(
	        'style' => 'article-uikit-text'
        ));
    }

}