<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitTopbarWithButtons
{

	public $corner_size = 7;

    public function uiKitTopbarWithButtons( $configs, array $custom_styles = array() ) {

        /** @var BootstrapComponent $this */


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
            ]);
        }

        $styles = array(
            'width' => 'auto',
            'height' => '50',
            'vertical-align' => 'middle',
        );

        if ( !empty($custom_styles) ) {
            $styles = array_merge($styles, $custom_styles);
        }


        $leftComponent = $this->getComponentColumn([
            $this->getComponent($configs['leftSection'])
            ],
            $this->getAction($configs['leftSection']),
            [
            'width' => $this->screen_width / $this->corner_size,
            'text-align' => 'left',
            'padding' => '0 0 0 15',
        ]);

        $centerComponent = $this->getComponentColumn([
            $this->getComponent($configs['centerSection'])
        ],
            $this->getAction($configs['centerSection']),
        [
            'text-align' => 'center',
            'width' => $this->screen_width - (2 * ($this->screen_width / $this->corner_size))
        ]);
        $rightSection = (isset($configs['rightSection']))?$configs['rightSection']:'';;
        $rightComponent = $this->getComponentColumn([
            $this->getComponent($rightSection)
            ],
            $this->getAction($rightSection),
            [
                'width' => $this->screen_width / $this->corner_size,
                'text-align' => 'right',
                'padding' => '0 15 0 0',
            ]);

        return $this->getComponentRow([
               $leftComponent,
               $centerComponent,
               $rightComponent
           ],[],$styles);
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

    private function getAction($content){
        if (isset($content['onclick'])&&!empty( $content['onclick'])){
            return array('onclick'=>$content['onclick']);
        }
        return array();
    }

}