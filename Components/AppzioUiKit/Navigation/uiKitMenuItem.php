<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;

trait uiKitMenuItem
{

    public function uiKitMenuItem($item = [], array $parameters = [], array $styles = [])
    {


        if (!isset($item['name']) AND !isset($item['label'])) {
            return $this->getComponentText('{#missing_name#}', [
                'style' => 'article-uikit-error'
            ]);
        }

        if (isset($item['icon']) AND $item['icon']) {
            $menu_content[] = $this->getComponentImage($item['icon'], [
                'style' => 'uikit_menu_item_image'
            ]);
        }

        if(isset($item['name'])){
            $name = $item['name'];
        } elseif(isset($item['label'])){
            $name = $item['label'];
        } else {
            $name = 'Unknown';
        }

        $menu_content[] = $this->getComponentText($name, [
            'style' => 'uikit_menu_item_label'
        ]);

        return $this->getComponentRow($menu_content, $this->getParameters($item, $parameters));
    }

    protected function getParameters($item, $parameters)
    {

        $openparams = [
            'back_button' => 1
        ];

        if (empty($parameters['style'])) {
            $parameters['style'] = 'uikit_menu_item_row';
        }

        if (!isset($item['link']) OR empty($item['link'])) {
            return $parameters;
        }

        if (isset($item['tab']) AND $item['tab']) {
            $openparams['tab_id'] = $item['tab'];
        }

        if (is_numeric($item['link'])) {
            $click['onclick'] = $this->getOnclickOpenAction(false, $item['link'], $openparams);
        } else if (stristr($item['link'], 'http')) {
            $click['onclick'] = $this->getOnclickOpenUrl($item['link']);
        } else if ($item['link'] == 'go-home') {
            $click['onclick'] = $this->getOnclickGoHome();
        } else {
            $click['onclick'] = $this->getOnclickOpenAction($item['link'], $openparams);
        }

        return array_merge($parameters, $click);
    }

}