<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleHeading {

	public $article;
	public $category_data;

    public function uiKitArticleHeading( $article, $category_data = false ){

    	$this->article = $article;
    	$this->category_data = $category_data;

	    $filename = $this->getImageFileName('main-bg-2.jpg', array(
		    'imgwidth' => '1440',
		    'imgheight' => '2560',
		    'priority' => 9,
	    ));

	    return $this->getComponentRow(array(
		    $this->getNavigationBar(),
		    $this->getArticleInfo(),
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
			    /*
			    $this->getComponentText('Header here', array(), array(
				    'width' => $this->screen_width - (2 * 30),
				    'color' => '#ffffff',
				    'font-size' => '20',
				    'text-align' => 'center',
			    )),
			    */
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

    public function getArticleInfo() {
	    return $this->getComponentColumn(array_merge(
			$this->getArticleDate(),
			$this->getArticleTitle(),
			$this-> getArticleCategory()
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

    public function getArticleDate() {
    	return array(
		    $this->getComponentRow(array(
			    $this->getComponentText(strtoupper(date('F j, Y', strtotime($this->article->article_date))), array(), array(
				    'width' => '100%',
				    'color' => '#cecece',
				    'font-size' => '16',
				    'text-align' => 'left',
				    'padding' => '10 10 10 10',
			    )),
		    ))
	    );
    }

    public function getArticleTitle() {
	    return array(
		    $this->getComponentRow(array(
			    $this->getComponentText($this->article->title, array(), array(
				    'width' => '100%',
				    'color' => '#ffffff',
				    'font-size' => '28',
				    'text-align' => 'left',
				    'padding' => '10 10 10 10',
			    )),
		    ))
	    );
    }

    public function getArticleCategory() {

    	if ( empty($this->category_data) ) {
    		return array();
	    }

	    return array(
		    $this->getComponentRow(array(
			    $this->getComponentText(strtoupper($this->category_data->title), array(), array(
				    'width' => '100%',
				    'color' => '#e0dfdf',
				    'font-size' => '16',
				    'text-align' => 'left',
				    'padding' => '10 10 10 10',
			    )),
		    ))
	    );
    }

}