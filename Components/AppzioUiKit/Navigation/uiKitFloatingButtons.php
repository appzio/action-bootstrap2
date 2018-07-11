<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitFloatingButtons
{

	public function uiKitFloatingButtons(array $buttons, $overlay = true,  $parameters = [], $styles = []) {
        /** @var BootstrapComponent $this */

        if ( empty($buttons) ) {
            return $this->uiKitDefaultHeader('{#missing_buttons#}');
        }

        $component_styles = [
            'text-align' => 'right',
            'margin' => '0 10 10 0'
        ];

        if ( $overlay ) {
            $layout = new \stdClass();
            $layout->bottom = '10';
            $layout->height = '80';
            $layout->right = '15';
            $layout->width = ( count($buttons) * 80 );

            $default_params['layout'] = $layout;
        }

        if ( !empty($styles) ) {
            $component_styles = array_merge($component_styles, $styles);
        }

        if ( !empty($parameters) ) {
            $parameters = array_merge($default_params, $parameters);
        }

        return $this->getComponentRow(
            $this->getButtons( $buttons ), $parameters, $component_styles
        );
    }

    private function getButtons( $buttons ) {

	    $data = [];

        foreach ($buttons as $button) {

            if ( !isset($button['icon']) OR empty($button['icon']) )
                continue;

            $parameters = [];

            if ( isset($button['onclick']) AND $button['onclick'] ) {
                $parameters['onclick'] = $button['onclick'];
            }

            $data[] = $this->getComponentImage($button['icon'], $parameters, [
                'width' => '70',
                'shadow-color' => '#DDE2DE',
                'shadow-radius' => '1',
                'shadow-offset' => '0 3',
            ]);
	    }

	    return $data;
    }

}