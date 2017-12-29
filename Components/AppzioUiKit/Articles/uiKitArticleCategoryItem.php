<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleCategoryItem {

    public function uiKitArticleCategoryItem( $category_item ){
    	
    	$parent_id = $category_item->parent_id;
	    $path = ( $parent_id ? 'materialscategorylisting' : 'materialslisting' );
	    $onclick = $this->getOnclickOpenAction($path,false,
		    array(
			    // 'id' => 'category-' . ( $parent_id ? $parent_id : $category_item->id ),
			    'id' => ( $parent_id ? $parent_id : $category_item->id ),
			    'sync_open' => 1,
			    'back_button' => 1
		    ));

	    $filename = $this->getImageFileName($category_item->picture, array(
		    'imgwidth' => '1440',
		    'imgheight' => '400',
		    'priority' => 9,
	    ));

        return $this->getComponentRow(array(
        	$this->getComponentColumn(array(
		        $this->getComponentColumn(array(
			        $this->getComponentText(strtoupper($category_item->title), array(), array(
				        'color' => '#ffffff',
				        'font-size' => '22',
				        'margin' => '0 0 0 0'
			        )),
			        $this->getComponentText(strtoupper($category_item->headertext), array(), array(
				        'color' => '#ffffff',
				        'font-size' => '12',
				        'margin' => '0 0 0 0'
			        )),
		        ), array(), array(
			        'text-align' => 'center',
			        'width' => '100%',
		        )),
	        ), array(), array(
		        'vertical-align' => 'middle',
		        'width' => $this->screen_width,
		        'height' => $this->screen_height / 4,
		        'background-image' => $this->getImageFileName('shadow-image-wide.png'),
		        'background-size' => 'cover',
	        )),
        ), array(
	        'onclick' => $onclick,
        ), array(
        	'vertical-align' => 'middle',
	        'background-image' => $filename,
	        'background-size' => 'cover',
	        'width' => $this->screen_width,
	        'height' => $this->screen_height / 4,
        ));
    }

}