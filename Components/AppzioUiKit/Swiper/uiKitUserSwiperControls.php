<?php

namespace Bootstrap\Components\AppzioUiKit\Swiper;
use Bootstrap\Components\BootstrapComponent;

trait uiKitUserSwiperControls {

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

    public function uiKitUserSwiperControls(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        $id = isset($parameters['id']) ? $parameters['id'] : false;
        $is_bookmarked = isset($parameters['is_bookmarked']) ? $parameters['is_bookmarked'] : false;
        $is_liked = isset($parameters['is_liked']) ? $parameters['is_liked'] : false;
        $is_unliked = isset($parameters['is_unliked']) ? $parameters['is_unliked'] : false;
        $right_click = isset($parameters['right_click']) ? $parameters['right_click'] : false;
        $left_click = isset($parameters['left_click']) ? $parameters['left_click'] : false;

        if(!$id){
            return $this->getComponentText('Missing id for uiKitUserSwiperControls!');
        }

        $nope = isset($parameters['nope']) ? $parameters['nope'] : 'uikit_swipe_nope.png';
        $yes = isset($parameters['yes']) ? $parameters['yes'] : 'uikit_swipe_like.png';
        $bookmark = isset($parameters['bookmark']) ? $parameters['bookmark'] : 'uikit_swipe_bookmark_active.png';
        $bookmark_inactive = isset($parameters['bookmark_inactive']) ? $parameters['bookmark_inactive'] : 'uikit_swipe_bookmark.png';

        if(!$right_click){
            $right_click = $this->getOnclickSwipeStackControl('swipe_container', 'right');
        }

        if(!$left_click){
            $left_click = $this->getOnclickSwipeStackControl('swipe_container', 'left');
        }

        $bookmark_inactive_click[] = $this->getOnclickShowElement('bookmark_active'.$id,['transition' => 'none']);
        $bookmark_inactive_click[] = $this->getOnclickHideElement('bookmark_inactive'.$id,['transition' => 'none']);
        $bookmark_inactive_click[] = $this->getOnclickSubmit('controller/bookmark/'.$id);

        $bookmark_active_click[] = $this->getOnclickHideElement('bookmark_active'.$id,['transition' => 'none']);
        $bookmark_active_click[] = $this->getOnclickShowElement('bookmark_inactive'.$id,['transition' => 'none']);
        $bookmark_active_click[] = $this->getOnclickSubmit('controller/removebookmark/'.$id);

        $left = $this->getComponentColumn([
            $this->getComponentImage($nope, array('onclick' => $left_click), ['width' => '70','vertical-align' => 'top',
                'shadow-color' => '#000000',
                'shadow-radius' => 1,
                'shadow-offset' => '0 0',
            ]),
        ],[],['height' => '90','vertical-align' => 'top','margin' => '0 15 0 0']);

        if($is_bookmarked){
            $bm = $this->getComponentColumn([
                $this->getComponentImage($bookmark_inactive, array('onclick' => $bookmark_inactive_click), ['height' => '40',
                    'shadow-color' => '#000000',
                    'shadow-radius' => 1,
                    'shadow-offset' => '0 0',
                ])
            ],['id' => 'bookmark_inactive'.$id,'visibility' => 'hidden'],['height' => '90','vertical-align' => 'bottom']);

            $bm2 = $this->getComponentColumn([
                $this->getComponentImage($bookmark, array('onclick' => $bookmark_active_click), ['height' => '40',
                    'shadow-color' => '#000000',
                    'shadow-radius' => 1,
                    'shadow-offset' => '0 0',
                ])
            ],['id' => 'bookmark_active'.$id],['height' => '90','vertical-align' => 'bottom']);
        } else {
            $bm = $this->getComponentColumn([
                $this->getComponentImage($bookmark_inactive, array('onclick' => $bookmark_inactive_click), ['height' => '40',
                    'shadow-color' => '#000000',
                    'shadow-radius' => 1,
                    'shadow-offset' => '0 0',
                ])
            ],['id' => 'bookmark_inactive'.$id],['height' => '90','vertical-align' => 'bottom']);

            $bm2 = $this->getComponentColumn([
                $this->getComponentImage($bookmark, array('onclick' => $bookmark_active_click), ['height' => '40',
                    'shadow-color' => '#000000',
                    'shadow-radius' => 1,
                    'shadow-offset' => '0 0',
                ])
            ],['id' => 'bookmark_active'.$id,'visibility' => 'hidden'],['height' => '90','vertical-align' => 'bottom']);
        }

        $right = $this->getComponentColumn([
            $this->getComponentImage($yes, array('onclick' => $right_click), ['width' => '70','vertical-align' => 'top',
                'shadow-color' => '#000000',
                'shadow-radius' => 1,
                'shadow-offset' => '0 0',
            ]),
        ],[],['height' => '90','vertical-align' => 'top','margin' => '0 0 0 15']);

        $col[] = $this->getComponentRow([
            $left,
            $bm,
            $bm2,
            $right
        ]);

        if(isset($parameters['layout'])){
            return $this->getComponentRow($col,['layout' => $parameters['layout']],[
                'margin' => '0 60 10 60',
                'text-align' => 'center',
                'noanimate' => true,
                'height' => '90']);
        } else {
            return $this->getComponentRow($col,[],[
                'margin' => '0 60 10 60',
                'text-align' => 'center',
                'noanimate' => true,
                'height' => '90']);
        }


    }




}