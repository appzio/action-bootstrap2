<?php

namespace Bootstrap\Components\AppzioUiKit\Swiper;
use Bootstrap\Components\BootstrapComponent;

trait uiKitUserSwiper {

    public $page = 0;

    /**
     * @param $content string, no support for line feeds
     * @param array $styles 'margin', 'padding', 'orientation', 'background', 'alignment', 'radius', 'opacity',
     * 'orientation', 'height', 'width', 'align', 'crop', 'text-style', 'font-size', 'text-color', 'border-color',
     * 'border-width', 'font-android', 'font-ios', 'background-color', 'background-image', 'background-size',
     * 'color', 'shadow-color', 'shadow-offset', 'shadow-radius', 'vertical-align', 'border-radius', 'text-align',
     * 'lazy', 'floating' (1), 'float' (right | left), 'max-height', 'white-space' (no-wrap), parent_style
     * @param array $parameters selected_state, variable, onclick, style
     * @return \stdClass
     */

    public function uiKitUserSwiper($content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        if(!is_array($content) OR empty($content)){
            return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        }

        $count = 0;

        foreach($content as $item){
            $swiper[] = $this->getFeaturedUser($item);
            $count++;
        }

        if(isset($swiper)){
            $out[] = $this->getComponentSwipeStack(
                $swiper,
                array(
                    'id' => 'swipe_container',
                    'transition' => 'tablet',
                    'world_ending' => 'refill_items'
                ));
            return $this->getComponentColumn($out);
        }

        return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        
    }

	private function getFeaturedUser($content){
        $icon = $content['profilepic'] ? $content['profilepic'] : 'icon_camera-grey.png';

        $col[] = $this->getComponentImage($icon,array(
            'style' => 'matching_featured_image','imgwidth' => '600','imgheight' => '600',
            'widht' => '300', 'height' => '300'));

        $swipeRight[]  = $this->getOnclickSwipeStackControl('swipe_container', 'right');
        $swipeLeft[] = $this->getOnclickSwipeStackControl('swipe_container', 'left');

        $col[] = $this->getComponentRow([
            $this->getComponentText('Dislike', array('onclick' => $swipeLeft), array('color' => "#FFFFFF")),
            $this->getComponentText('Like', array('onclick' => $swipeRight), array('color' => "#FFFFFF")),
        ]);

        $action = $this->getOnclickOpenAction(
            'userinfo',
            false,
            array('sync_open' => 1, 'back_button' => 1, 'id' => $content['play_id'].'-currentprofileview')
/*            'Profile/default/open_match-' . $content['play_id'],
            false,
            array('id' => '-currentprofileview' .$content['play_id'])*/
        );

        return $this->getComponentColumn($col, array(
            'onclick' => $action,
            'leftswipeid' => 'left' . $content['play_id'],
            'rightswipeid' => 'right' . $content['play_id'],
            'style' => 'matching_featured_column'
        ));
    }

}