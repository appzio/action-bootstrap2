<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleNextentry
{

    public function uiKitArticleNextentry($article_data, $category_data)
    {

        $filename = $this->getImageFileName($this->getListingImage($article_data->photos), array(
            'imgwidth' => '400',
            'imgheight' => '400',
            'priority' => 9,
        ));

        $onclick = $this->getOnclickOpenAction('article', false,
            array(
                'id' => $article_data->id,
                'sync_open' => 1,
                'back_button' => 1
            ));

        return $this->getComponentRow(array(
            $this->getComponentColumn(array(), array(), array(
                'width' => $this->screen_width / 3,
                'height' => '100%',
                'background-image' => $this->getImageFileName($filename),
                'background-size' => 'cover',
            )),
            $this->getComponentColumn(array(
                $this->getComponentText(strtoupper('{#read_next#}'), array(
                    'style' => 'article-uikit-related-heading'
                )),
                $this->getComponentRow(array(
                    $this->getComponentText(strtoupper($category_data->title), array(
                        'style' => 'article-uikit-related-category'
                    )),
                ), array(), array(
                    'padding' => '0 0 5 0',
                )),
                $this->getComponentText($article_data->title, array(
                    'style' => 'article-uikit-related-title'
                )),
                $this->getComponentSpacer(10),
                /*
                $this->getComponentRow(array(
                    $this->getComponentText(strtoupper(date('F j, Y', strtotime($article_data->article_date))), array(
                        'style' => 'article-uikit-related-date'
                    )),
                ), array(), array(
                    'padding' => '0 0 10 0',
                )),
                */
            ), array(
                'style' => 'article-uikit-related-item'
            ))
        ), array(
            'onclick' => $onclick
        ), array(
            'padding' => '10 0 0 0'
        ));
    }

}