<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleItem
{

    private $height_proportion = 5.5;

    public function uiKitArticleItem($article, $category_data)
    {

        $onclick = $this->getOnclickOpenAction('article', false,
            array(
                'id' => $article->id,
                'sync_open' => 1,
                'back_button' => 1
            ));

        if ($article->link) {
            $onclick = $this->getOnclickShowDiv('video-article-' . $article->id, $this->uiKitArticleDivLayout());
        }

        if (isset($category_data->title)) {
            $category_title = strtoupper($category_data->title);
        } else {
            $category_title = 'N/A';
        }

        return $this->getComponentRow(array(
            $this->getComponentColumn(array(
                $this->getComponentImage($this->getListingImage($article->photos), array(
                    'style' => 'article-uikit-listing-image',
                    'imgwidth' => '400',
                    'imgheight' => '400',
                    'lazy' => 1,
                    'priority' => 9,
                ), array(
                    'crop' => 'yes',
                ))
            ), array(), array(
                'width' => '35%',
                'height' => $this->screen_height / $this->height_proportion,
            )),
            $this->getComponentColumn(array(
                $this->getComponentText($article->title, array(
                    'style' => 'article-uikit-listing-title',
                )),
                $this->getComponentRow(array(
                    $this->getComponentText($category_title, array(
                        'style' => 'article-uikit-listing-subtitle',
                    )),
                )),
                /*
                $this->getComponentRow(array(
                    $this->getComponentText(strtoupper(date('F j, Y', strtotime($article->article_date))), array(
                        'style' => 'article-uikit-listing-date',
                    )),
                ))
                */
            ), array(), array(
                'width' => 'auto',
                'height' => $this->screen_height / $this->height_proportion,
                'padding' => '0 10 0 10',
            )),
        ), array(
            'onclick' => $onclick,
        ), array(
            'margin' => '0 15 0 15',
            'width' => 'auto',
            'height' => $this->screen_height / $this->height_proportion,
        ));
    }

    private function getListingImage($images)
    {

        if (empty($images)) {
            return 'article-uikit-listing-placeholder.png';
        }

        foreach ($images as $image) {
            if ($image->position == 'listing') {
                return $image->photo;
            }
        }

        return 'article-uikit-listing-placeholder.png';
    }

    private function uiKitArticleDivLayout()
    {
        $layout = new \stdClass();
        $layout->top = 80;
        $layout->bottom = 0;
        $layout->left = 0;
        $layout->right = 0;

        return array(
            'background' => 'blur',
            'tap_to_close' => 1,
            'transition' => 'from-bottom',
            'layout' => $layout
        );
    }

}