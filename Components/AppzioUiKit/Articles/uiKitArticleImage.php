<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleImage {

    public function uiKitArticleImage( $params ){
        return $this->getComponentImage($params['image_id'], array(), array(
			'margin' => '10 0 10 0'
        ));
    }

}