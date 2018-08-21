<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleHeading {

	public $article;
	public $category_data;

    public function uiKitArticleHeading( $article, $category_data = false ){

    	$this->article = $article;
    	$this->category_data = $category_data;

    	$image = $this->uiKitArticleFeaturedImage( $article->photos );

    	if ( empty($image) ) {
		    return $this->getComponentColumn(array_merge(
			    array(
				    $this->getComponentRow(array(
					    $this->getComponentImage('arrow-back-black-v2.png', array(
						    'onclick' => $this->getOnclickGoHome()
					    ), array(
						    'height' => '30',
					    )),
				    ), array(), array(
					    'padding' => '15 15 15 15',
				    ))
			    ),
			    $this->uiKitArticleCategory(),
			    $this->uiKitArticleTitle('article-uikit-title-dark')
		    ), array(), array(
			    'vertical-align' => 'top',
			    'margin' => '0 0 5 0',
			    'width' => $this->screen_width,
		    ));
	    }

	    $filename = $this->getImageFileName($image, array(
		    'imgwidth' => '1440',
		    'imgheight' => '2560',
		    'priority' => 9,
	    ));

	    return $this->getComponentRow(array(
		    $this->uiKitArticleNavigationBar(),
		    $this->uiKitArticleInfo(),
	    ), array(), array(
		    'vertical-align' => 'top',
		    'background-image' => $filename,
		    'background-size' => 'cover',
		    'margin' => '0 0 5 0',
		    'width' => $this->screen_width,
		    'height' => $this->screen_height,
	    ));

    }

    private function uiKitArticleNavigationBar() {
    	return $this->getComponentColumn(array(
		    $this->getComponentRow(array(
			    $this->getComponentImage('arrow-back-white-v2.png', array(
			    	'onclick' => $this->getOnclickGoHome()
			    ), array(
				    'height' => '30',
			    )),
		    ))
	    ), array(), array(
		    'width' => '100%',
		    'height' => '100',
		    'padding' => '15 15 15 15',
		    'background-image' => $this->getImageFileName('shadow-image-wide-inverted.png', array(
			    'imgwidth' => '1366',
			    'imgheight' => '768',
		    )),
		    'background-size' => 'cover',
	    ));
    }

    private function uiKitArticleInfo() {
	    return $this->getComponentColumn(array_merge(
		    $this->uiKitArticleCategory(),
			$this->uiKitArticleTitle()
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

    private function uiKitArticleDate() {
    	return array(
		    $this->getComponentRow(array(
			    $this->getComponentText(strtoupper(date('F j, Y', strtotime($this->article->article_date))), array(
				    'style' => 'article-uikit-date'
			    )),
		    ))
	    );
    }

    private function uiKitArticleTitle( $style_class = 'article-uikit-title' ) {
	    return array(
		    $this->getComponentRow(array(
			    $this->getComponentText($this->article->title, array(
			    	'style' => $style_class
			    )),
		    ))
	    );
    }

    private function uiKitArticleCategory() {

    	if ( !isset($this->category_data->title) ) {
    		return array();
	    }

	    return array(
		    $this->getComponentRow(array(
			    $this->getComponentText(strtoupper($this->category_data->title), array(
				    'style' => 'article-uikit-category'
			    )),
		    ))
	    );
    }

    private function uiKitArticleFeaturedImage( $images ) {

		if ( empty($images) ) {
			return false;
		}

		foreach ( $images as $image ) {
			if ( $image->position == 'featured' ) {
				return $image->photo;
			}
		}

		return false;
	}

}