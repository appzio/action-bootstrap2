<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleCategoryItem {

    public function uiKitArticleCategoryItem( array $category_item, $parameters = array() ){
    	
    	$has_direct_ascendants = $category_item['children'];
	    $path = ( $has_direct_ascendants ? 'materialscategorylisting' : 'materialslisting' );
	    $box_ratio = ( isset($parameters['box_ratio']) ? $parameters['box_ratio'] : 3 );

	    $onclick = $this->getOnclickOpenAction($path,false,
		    array(
			    'id' => $category_item['id'],
			    'sync_open' => 1,
			    'sync_close' => 1,
			    'back_button' => 1
		    ));

	    $filename = $this->getImageFileName($category_item['picture'], array(
		    'imgwidth' => '1440',
		    'imgheight' => ( $box_ratio == 2 ? '800' : '600' ),
		    'priority' => 9,
	    ));

        return $this->getComponentRow(array(
        	$this->getComponentColumn(array(
		        $this->getComponentColumn(array(
			        $this->getComponentText(strtoupper($category_item['title']), array(
			        	'style' => 'article-uikit-category-title'
			        )),
			        $this->getComponentText(strtoupper($category_item['headertext']), array(
				        'style' => 'article-uikit-category-description'
			        )),
		        ), array(), array(
			        'vertical-align' => 'top',
			        'margin' => '20 0 0 0',
			        'text-align' => 'center',
			        'width' => '100%',
		        )),
	        ), array(), array(
		        'width' => $this->screen_width,
		        'height' => ($this->screen_height / $box_ratio) - 25,
		        'background-image' => $this->getImageFileName('shadow-image-wide-inverted.png'),
		        'background-size' => 'cover',
	        )),
        ), array(
	        'onclick' => $onclick,
        ), array(
        	'vertical-align' => 'middle',
	        'background-image' => $filename,
	        'background-size' => 'cover',
	        'width' => $this->screen_width,
	        'height' => ($this->screen_height / $box_ratio) - 25,
        ));
    }

}