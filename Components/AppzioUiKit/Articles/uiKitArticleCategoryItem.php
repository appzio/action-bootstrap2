<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleCategoryItem {

    public function uiKitArticleCategoryItem( $item, $i ){

	    $onclick = $this->getOnclickOpenAction('materialslisting',false,
		    array(
			    'id' => 'category-' . $i,
			    'sync_open' => 1,
			    'back_button' => 1
		    ));

        return $this->getComponentText($item, array(
        	'onclick' => $onclick
        ));
    }

}