<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleNote {

    public function uiKitArticleNote( $params ){

	    $color = $params['color'] ? $params['color'] : '#676b6f';
	    $background = $params['background-color'] ? $params['background-color'] : '#ffe88c';

        return $this->getComponentColumn($this->getParsedContent($params['content'], array(
        	'color' => $color
        )), array(), array(
        	'background-color' => $background
        ));
    }

}