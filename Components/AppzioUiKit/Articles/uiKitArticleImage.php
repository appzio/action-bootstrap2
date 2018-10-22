<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleImage
{

    public function uiKitArticleImage($params, $styles = array())
    {

        if (!isset($params['image_id']) OR empty($params['image_id'])) {
            return $this->getComponentText('{#missing_image_path#}', array(
                'style' => 'article-uikit-error'
            ));
        }

        return $this->getComponentImage($params['image_id'], array(
            'lazy' => 1,
            'priority' => 9,
        ), array(
            'margin' => '10 0 10 0'
        ));
    }

}