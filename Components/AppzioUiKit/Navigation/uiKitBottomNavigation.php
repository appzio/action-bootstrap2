<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitBottomNavigation
{

    public function uiKitBottomNavigation($content = array(), $parameters = array(), $styles = array()) {
        /** @var BootstrapComponent $this */
        $tabs = array();

        foreach ($content as $tab) {
            $tabs[] = $this->getBottomTab($tab, count($content), $styles);
        }

        return $this->getComponentRow($tabs, $parameters, array(
            'width' => '100%',
            'background-color' => $this->color_top_bar_color
        ));
    }

    private function getBottomTab($tab, $count, $styles) {

        $text = $tab['label'];
        $icon = $tab['icon'];
        $width = $this->screen_width / $count;

        $params = [];

        if ( isset($tab['onclick']) ) {
            $params['onclick'] = $tab['onclick'];
        }

        return $this->getComponentColumn([
            $this->getComponentImage($icon, [], [
                'width' => 21,
                'margin' => '6 0 0 0',
            ]),
            $this->getComponentText($text, [], [
                'font-size' => '12',
                'padding' => '0 0 0 0',
                'margin' => '2 0 6 0',
                'color' => '#ffffff',
            ]),
        ], $params, [
            'width' => $width,
            'text-align' => 'center',
        ]);
    }

}