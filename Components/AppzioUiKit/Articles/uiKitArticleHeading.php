<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleHeading {

    public function uiKitArticleHeading( $params ){

	    $filename = $this->getImageFileName($params['image_id'], array(
		    'imgwidth' => '1440',
		    'imgheight' => '2560',
		    'priority' => 9,
	    ));

	    return $this->getComponentRow(array(
		    $this->getNavigationBar(),
		    $this->getArticleTitle( $params['title'] ),
	    ), array(), array(
		    'vertical-align' => 'top',
		    'background-image' => $filename,
		    'background-size' => 'cover',
		    'width' => $this->screen_width,
		    'height' => $this->screen_height,
	    ));

    }

    public function getNavigationBar() {
    	return $this->getComponentColumn(array(
		    $this->getComponentRow(array(
			    $this->getComponentImage('arrow-back-white.png', array(
			    	'onclick' => $this->getOnclickGoHome()
			    ), array(
				    'width' => '30',
			    )),
			    $this->getComponentText('Header here', array(), array(
				    'width' => $this->screen_width - (2 * 30),
				    'color' => '#ffffff',
				    'font-size' => '20',
				    'text-align' => 'center',
			    )),
		    ))
	    ), array(), array(
		    'width' => '100%',
		    'height' => '100',
		    'padding' => '10 10 10 10',
		    'background-image' => $this->getImageFileName('shadow-image-wide-inverted.png', array(
			    'imgwidth' => '1366',
			    'imgheight' => '768',
		    )),
		    'background-size' => 'cover',
	    ));
    }

    public function getArticleTitle( $title ) {
	    return $this->getComponentColumn(array(
		    $this->getComponentRow(array(
			    $this->getComponentText('APRIP 2, 2017', array(), array(
				    'width' => '100%',
				    'color' => '#cecece',
				    'font-size' => '16',
				    'text-align' => 'left',
				    'padding' => '10 10 10 10',
			    )),
		    )),
		    $this->getComponentRow(array(
			    $this->getComponentText('Three lined Header Finibus Bonorum et Malorum', array(), array(
				    'width' => '100%',
				    'color' => '#ffffff',
				    'font-size' => '28',
				    'text-align' => 'left',
				    'padding' => '10 10 10 10',
			    )),
		    )),
		    $this->getComponentRow(array(
			    $this->getComponentText('CATEGORY 2', array(), array(
				    'width' => '100%',
				    'color' => '#e0dfdf',
				    'font-size' => '16',
				    'text-align' => 'left',
				    'padding' => '10 10 10 10',
			    )),
		    )),
	    ), array(), array(
		    'width' => '100%',
		    'height' => $this->screen_height - 100,
		    'padding' => '0 0 20 0',
		    'floating' => '1',
		    'vertical-align' => 'bottom',
		    'background-image' => $this->getImageFileName('shadow-image-wide.png', array(
			    'imgwidth' => '1366',
			    'imgheight' => '768',
		    )),
		    'background-size' => 'cover',
	    ));
    }

}