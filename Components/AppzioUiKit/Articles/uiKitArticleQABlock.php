<?php

namespace Bootstrap\Components\AppzioUiKit\Articles;

trait uiKitArticleQABlock
{

    public function uiKitArticleQABlock($params, $styles = array())
    {
        return $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentText($params['question'], array('style' => 'article-uikit-text'))
            ), array(), array(
                'background-color' => '#f7f7f7',
            )),
            $this->getComponentRow(array(
                $this->getComponentText($params['answer'], array('style' => 'article-uikit-text'))
            ), array()),
            $this->getComponentDivider(array(
                'style' => 'article-uikit-divider'
            )),
        ));
    }

}