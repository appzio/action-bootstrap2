<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitTopbarWithButtons
{

    public function uiKitTopbarWithButtons( $configs, array $custom_styles = array() ) {
        /** @var BootstrapComponent $this */

        $top_bar_width_index = 6;

        $params = [
            'leftSection' => [
                'required' => false,
                'param' => 'image',
            ],
            'centerSection' => [
                'required' => true,
                'param' => 'text',
            ],
            'rightSection' => [
                'required' => false,
                'param' => 'image',
            ]
        ];

        $config_error = false;
        foreach ($params as $item_key => $item_params) {

            if ( $item_params['required'] AND !isset($configs[$item_key]) ) {
                $config_error = true;
                break;
            }
        }

        if ( $config_error ) {
            return $this->getComponentText('{#configuration_error#}', [], [
                'text-align' => 'center'
            ]);
        }
        $styles = array(
            'width' => 'auto',
            'height' => '50',
            'vertical-align' => 'middle',
            'background-color' => $this->color_top_bar_color,
        );
        if ($styles['background-color']=='transparent')
        {
            unset($styles['background-color']);
        }

        if ( !empty($custom_styles) ) {
            $styles = array_merge($styles, $custom_styles);
        }

        $right_data = [];

        if ( isset($configs['rightSection']) AND $configs['rightSection'] ) {
            foreach ($configs['rightSection'] as $i => $entry) {

                // Decrise the width index so the icons can actually fit
                if ( $i )
                    $top_bar_width_index -= 1.5;

                if ( $i > 2 )
                    continue;

                $right_data[] = $this->getComponentIcon($entry);
            }
        }

        $leftComponent = $this->getComponentColumn([
            $this->getComponent($configs['leftSection'])
        ], $this->getAction($configs['leftSection']), [
            'width' => $this->screen_width / $top_bar_width_index,
            'text-align' => 'left',
            'padding' => '0 0 0 15',
        ]);

        $centerComponent = $this->getComponentColumn([
            $this->getComponent($configs['centerSection'])
        ], $this->getAction($configs['centerSection']), [
            'text-align' => 'center',
            'width' => $this->screen_width - (2 * ($this->screen_width / $top_bar_width_index))
        ]);

        $rightComponent = $this->getComponentColumn([
            $this->getComponentRow($right_data, [], [
                'vertical-align' => 'middle'
            ])
        ], [], [
            'width' => $this->screen_width / $top_bar_width_index,
            'text-align' => 'right',
            'padding' => '0 15 0 0',
        ]);

        return $this->getComponentRow([
           $leftComponent,
           $centerComponent,
           $rightComponent
        ], [], $styles);
    }

    private function getComponent($content){

        if (isset($content['title'])){
            return $this->getComponentText($content['title'], [],[
                'font-size' => '17',
                'color' => '#ffffff',
                'text-align' => 'center',
            ]);
        }

	    if (isset($content['image'])&&!empty($content['image'])){
            return $this->getComponentImage($content['image'], [],[
                'height' => '25',
            ]);
        }

        return $this->getComponentText('');
    }
    
    private function getComponentIcon($content) {

        if ( !isset($content['image']) OR empty($content['image']) ) {
            return $this->getComponentText('');
        }

        return $this->getComponentImage($content['image'], $this->getAction($content), [
            'height' => '25',
            'margin' => '0 0 0 8',
        ]);
    }

    private function getAction($content){

        $action = [];
        if (isset($content['onclick'])&&!empty( $content['onclick'])){
            $action['onclick'] = $content['onclick'];
        }
        if (isset($content['variable'])&&!empty($content['variable'])){
            $action['variable'] = $content['variable'];
        }
        return $action;
    }

}