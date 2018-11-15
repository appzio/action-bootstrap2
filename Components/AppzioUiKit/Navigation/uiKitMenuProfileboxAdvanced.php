<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitMenuProfileboxAdvanced
{

    public function uiKitMenuProfileboxAdvanced($image, $text, array $parameters = [], array $styles = []) {

        if ( empty($image) ) {
            return $this->getComponentText('{#missing_image#}', [
                'style' => 'article-uikit-error'
            ]);
        }

        $action = isset($parameters['profile_action']) ? $parameters['profile_action'] : 'myprofile';
        $profile_icon = isset($parameters['profile_icon']) ? $parameters['profile_icon'] : 'icon-user-profile-queer.png';

        $parameters['onclick'] = $this->getOnclickOpenAction($action);

        $component_styles = array_merge(
            array(
                'vertical-align' => 'middle',
            ),
            $styles
        );

        $top[] = $this->getComponentImage($image, [
            'style' => 'uikit_menu_profile_image',
            'priority' => '9',
        ]);

        $top[] = $this->getComponentText($text, [
            'style' => 'uikit_menu_profile_label'
        ]);

        if(isset($parameters['address']) AND $parameters['address']){
            $top[] = $this->getComponentText($parameters['address'], [

            ],['font-size' => 12,'margin' => '-8 0 10 0']);
        }

        $col[] = $this->getComponentColumn($top,[],['text-align' => 'center','margin' => '15 0 0 0']);

        if(isset($parameters['progress']) AND $parameters['progress']){
            $row[] = $this->getComponentImage($profile_icon,['style' => 'uikit_menu_item_image']);
            $row[] = $this->getComponentText('{#profile#}',['style' => 'uikit_menu_item_label']);
            $row[] = $this->getComponentProgress($parameters['progress'],[
                'track_color' => '#B2B4B3',
                'progress_color' => '#FAC858'
            ],[
                'width' => '70',
                'height' => '8',
                'border-radius' => '4',
                'margin' => '0 0 0 15'
            ]);

            $percentage = $parameters['progress']*100 .'%';

            if($parameters['progress'] < 0.5){
                $row[] = $this->getComponentText($percentage,[],['font-size' => 12,'margin' => '0 0 0 10','color' => '#B41C11']);
            } else {
                $row[] = $this->getComponentText($percentage,[],['font-size' => 12,'margin' => '0 0 0 10','color' => '#000000']);
            }

            $col[] = $this->getComponentDivider();
            $col[] = $this->getComponentRow($row,[],['vertical-align' => 'middle','padding' => '8 15 8 15']);
        }

        return $this->getComponentColumn($col,$parameters,$component_styles);

    }

}