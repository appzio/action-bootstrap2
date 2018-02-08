<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleGallery {

    public function uiKitArticleGallery( array $params, $styles = array() ){

    	if ( !isset($params['images']) OR empty($params['images']) ) {
    		return $this->getComponentText('{#missing_gallery_images#}', array(
    			'style' => 'article-uikit-error'
		    ));
	    }
	    
	    $images = $params['images'];

    	$items = [];

	    foreach ( $images as $image ) {
		    $items[] = $this->getComponentImage($image, array(
			    'imgwidth' => $this->screen_width,
			    'priority' => 9,
		    ), array(
			    'width' => $this->screen_width
		    ));
    	}

	    $col[] = $this->getComponentSwipe($items, array(
	    	'id' => 'gallery-' . $params['ref']
	    ));

	    $col[] = $this->getComponentSwipeAreaNavigation('#545050','#E1E4E3',array('swipe_id' => 'additional'));

		return $this->getComponentColumn($col, array(), array(
			'text-align' => 'center'
		));
    }

}