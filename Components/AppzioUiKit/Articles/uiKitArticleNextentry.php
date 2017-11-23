<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleNextentry {

    public function uiKitArticleNextentry(){
        return $this->getComponentColumn(array(
        	$this->getComponentSpacer(20),
	        $this->getComponentText( 'Block linking to next article' ),
        ));
    }

}