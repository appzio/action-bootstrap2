<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleVideo {

    public function uiKitArticleVideo( $params, $styles = array() ){

    	if ( !isset($params['video_link']) OR empty($params['video_link']) ) {
    		return $this->getComponentText('{#missing_video_link#}', array(
    			'style' => 'article-uikit-error'
		    ));
	    }

        return $this->getComponentVideo($params['video_link'], array(
	        'showplayer' => 1,
	        'autostart' => ( isset($params['autostart']) ? $params['autostart'] : 0 ),
        ), array(
        	'margin' => '0 0 15 0'
        ));
    }

}