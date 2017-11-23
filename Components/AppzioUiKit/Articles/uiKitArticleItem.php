<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleItem {

    public function uiKitArticleItem( $item, $i ){

	    $onclick = $this->getOnclickOpenAction('article',false,
		    array(
			    'id' => 'article-' . $i,
			    'sync_open' => 1,
			    'back_button' => 1
		    ));

        return $this->getComponentText($item, array(
        	'onclick' => $onclick,
        ));
    }

}