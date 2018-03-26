<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitMenuItem
{

    public function uiKitMenuItem($item = [], $parameters = [], $styles = []) {

        if ( !isset($item['label']) ) {
            return $this->getComponentText('{#missing_label#}', [
                'style' => 'article-uikit-error'
            ]);
        }

        if ( isset($item['icon']) AND $item['icon'] ) {
            $menu_content[] = $this->getComponentImage($item['icon'], [
                'style' => 'uikit_menu_item_image'
            ]);
        }

        $menu_content[] = $this->getComponentText($item['label'], [
            'style' => 'uikit_menu_item_label'
        ]);

        return $this->getComponentRow($menu_content, $this->getParameters( $item, $parameters ));
    }

    protected function getParameters( $item, $parameters ) {

        if ( empty($parameters['style']) ) {
            $parameters['style'] = 'uikit_menu_item_row';
        }

        if ( !isset($item['link']) OR empty($item['link']) ) {
            return $parameters;
        }

        $click['onclick'] = $this->getOnclickOpenAction( $item['link'] );

        return array_merge($parameters, $click);
    }

}