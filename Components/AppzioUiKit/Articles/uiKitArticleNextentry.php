<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleNextentry {

    public function uiKitArticleNextentry( $article_data, $category_data ){
    	
	    $filename = $this->getImageFileName('2.png', array(
		    'imgwidth' => '800',
		    'imgheight' => '800',
		    'priority' => 9,
	    ));

	    $onclick = $this->getOnclickOpenAction('article',false,
		    array(
			    'id' => $article_data->id,
			    'sync_open' => 1,
			    'back_button' => 1
		    ));

        return $this->getComponentRow(array(
        	$this->getComponentColumn(array(
	        ), array(), array(
		        'width' => $this->screen_width / 3,
		        'height' => '100%',
		        'background-image' => $this->getImageFileName($filename),
		        'background-size' => 'cover',
	        )),
	        $this->getComponentColumn(array(
				$this->getComponentText('READ NEXT', array(), array(
					'color' => '777d81',
					'font-size' => '17',
					'padding' => '10 0 10 0',
				)),
		        $this->getComponentText($article_data->title, array(), array(
			        'color' => '1d1d1d',
			        'font-size' => '20',
			        'font-weight' => 'bold',
			        'padding' => '0 0 10 0',
		        )),
		        $this->getComponentRow(array(
		        	$this->getComponentText(strtoupper($category_data->title), array(), array(
		        		'color' => '#777d81',
		        		'font-size' => '14',
			        )),
		        ), array(), array(
		        	'padding' => '0 0 5 0',
		        )),
		        $this->getComponentRow(array(
			        $this->getComponentText(strtoupper(date('F j, Y', strtotime($article_data->article_date))), array(), array(
				        'color' => '#bbbbbb',
				        'font-size' => '12',
			        )),
		        ), array(), array(
			        'padding' => '0 0 10 0',
		        )),
	        ), array(), array(
		        'width' => 'auto',
		        'padding' => '0 10 0 10',
		        'border-width' => 1,
		        'border-color' => '#d9d9d9',
	        ))
        ), array(
        	'onclick' => $onclick
        ), array(
        	'padding' => '10 0 0 0'
        ));
    }

}