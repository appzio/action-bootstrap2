<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleNote {

    public function uiKitArticleNote( $params, $styles = array() ){

	    if ( !isset($styles['color']) ) {
			$styles['color'] = '#676b6f';
	    }

        return $this->getComponentColumn($this->getParsedContent($params['content'], $styles), array(), array(
        	'background-color' => ( isset($styles['background-color']) ? $styles['background-color'] : '#ffe88c' )
        ));

    }

}