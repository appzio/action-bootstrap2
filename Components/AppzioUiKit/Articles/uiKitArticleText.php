<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleText {

    public function uiKitArticleText( $params ) {
        return $this->getComponentText($params['content'], array(), array(
			'color' => '#676b6f',
			'font-size' => '17',
			'padding' => '15 10 15 10',
        ));
    }

}