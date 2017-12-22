<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleQABlock {

    public function uiKitArticleQABlock( $params ){
        return $this->getComponentText(strtoupper($params['question']) . ': ' . $params['answer'], array(), array(
	        'color' => '#676b6f',
	        'font-size' => '17',
        	'padding' => '10 10 10 10'
        ));
    }

}