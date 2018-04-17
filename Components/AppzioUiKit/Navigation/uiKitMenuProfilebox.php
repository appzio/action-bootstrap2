<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitMenuProfilebox
{

    public function uiKitMenuProfilebox($image, $text, array $parameters = [], array $styles = []) {

        if ( empty($image) ) {
            return $this->getComponentText('{#missing_image#}', [
                'style' => 'article-uikit-error'
            ]);
        }

        $component_styles = array_merge(
            array(
                'padding' => '10 15 10 15',
                'vertical-align' => 'middle',
            ),
            $styles
        );

        return $this->getComponentRow([
            $this->getComponentColumn([
                $this->getComponentImage($image, [
                    'style' => 'uikit_menu_profile_image',
                    'priority' => '9',
                ]),
            ]),
            $this->getComponentColumn([
                $this->getComponentText($text, [
                    'style' => 'uikit_menu_profile_label'
                ]),
            ]),
        ], $parameters, $component_styles);
    }

}