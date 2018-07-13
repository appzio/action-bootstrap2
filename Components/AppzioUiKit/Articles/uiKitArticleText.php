<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleText {

    public function uiKitArticleText( $params, $styles = array() ) {
        return $this->getComponentColumn(
	        $this->getParsedContent($params['content'], $styles),
            $this->getEntryParams($params)
        );
    }

}