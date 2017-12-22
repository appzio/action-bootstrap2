<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleItem {

    public function uiKitArticleItem( $item, $i ){

	    $stack = array(
		    '1.jpg', '2.jpg', '3.jpg', '4.jpg',
	    );

	    $rand = rand( 0, 3 );
	    $image = $stack[$rand];

	    $onclick = $this->getOnclickOpenAction('article',false,
		    array(
			    'id' => 'article-' . $i,
			    'sync_open' => 1,
			    'back_button' => 1
		    ));

        return $this->getComponentRow(array(
	        $this->getComponentColumn(array(
		        $this->getComponentImage($image, array(
			        'imgwidth' => '400',
			        'imgheight' => '400',
			        'lazy' => 1,
			        'priority' => 9,
		        ), array(
			        'width' => '400',
			        'height' => '400',
			        'crop' => 'yes',
		        ))
	        ), array(), array(
		        'width' => '40%',
		        'height' => $this->screen_height / 5,
	        )),
	        $this->getComponentColumn(array(
		        $this->getComponentText($item, array(), array(
		        	'font-size' => '21',
		        	'font-weight' => 'bold',
		        	'margin' => '0 0 0 0',
		        )),
		        $this->getComponentRow(array(
			        $this->getComponentText('Category 1', array(), array(
				        'color' => '#777d81',
				        'margin' => '0 0 0 0',
			        )),
			        $this->getComponentVerticalSpacer('20'),
			        $this->getComponentText('APRIL 2, 2017', array(), array(
				        'color' => '#777d81',
				        'margin' => '0 0 0 0',
			        )),
		        ))
	        ), array(), array(
		        'width' => 'auto',
		        'height' => $this->screen_height / 5,
		        'padding' => '20 0 0 10',
		        // 'vertical-align' => 'middle',
	        )),
        ), array(
	        'onclick' => $onclick,
        ), array(
	        'margin' => '0 10 0 10',
	        'width' => $this->screen_width,
	        'height' => $this->screen_height / 5,
        ));
    }

}