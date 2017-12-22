<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleNextentry {

    public function uiKitArticleNextentry(){

	    $filename = $this->getImageFileName('2.jpg', array(
		    'imgwidth' => '800',
		    'imgheight' => '800',
		    'priority' => 9,
	    ));

        return $this->getComponentRow(array(
        	$this->getComponentColumn(array(
		        /*$this->getComponentImage('2.jpg', array(
			        'imgwidth' => '800',
			        'imgheight' => '800',
		        ), array(
			        'height' => 'auto',
		        )),*/
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
		        $this->getComponentText('It has survived not', array(), array(
			        'color' => '1d1d1d',
			        'font-size' => '22',
			        'font-weight' => 'bold',
			        'padding' => '0 0 20 0',
		        )),
		        $this->getComponentRow(array(
		        	$this->getComponentText('CATEGORY 3', array(), array(
		        		'color' => '#777d81',
		        		'font-size' => '15',
			        )),
		        	$this->getComponentVerticalSpacer('20'),
			        $this->getComponentText('APRIL 3, 2017', array(), array(
				        'color' => '#bbbbbb',
				        'font-size' => '15',
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
        ), array(), array(
        	'padding' => '10 0 0 0'
        ));
    }

}