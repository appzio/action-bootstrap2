<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleBlockquote {

    public function uiKitArticleBlockquote( $params ){
        return $this->getComponentRow(array(
        	$this->getComponentImage('quotes.png', array(), array(
        		'width' => 30
	        )),
	        $this->getComponentText($params['content'], array(), array(
	        	'font-size' => '22',
	        	'color' => '#1d1d1d',
	        	'padding' => '0 0 0 10',
	        ))
        ), array(), array(
        	'vertical-align' => 'top',
        	'padding' => '10 10 10 10',
        ));
    }

}