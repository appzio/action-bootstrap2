<?php

namespace Bootstrap\Components\AppzioUiKit\Swiper;
use Bootstrap\Components\BootstrapComponent;

trait uiKitUserSwiperFullScreen {

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

    public function uiKitUserSwiperFullScreen($content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        if(!is_array($content) OR empty($content)){
            return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        }

        $count = 0;

        foreach($content as $item){
            $swiper[] = $this->getFeaturedUserFullScreen($item,$parameters);
            $count++;
        }

        if(isset($swiper)){
            $out[] = $this->getComponentSwipeStack(
                $swiper,
                array(
                    'id' => 'swipe_container',
                    'overlay_left' => $this->getComponentImage('uikit_swipe_nope_overlay.png',array('text-align' => 'right','width'=> '350','height'=> '350')),
                    'overlay_right' => $this->getComponentImage('uikit_swipe_like_overlay.png',array('text-align' => 'left','width'=> '350','height'=> '350'))
                ),[]);
            return $this->getComponentColumn($out);
        }

        return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        
    }

	private function getFeaturedUserFullScreen($content,$parameters){

        $id = isset($content['play_id']) ? $content['play_id'] : false;

        if(!$id){
            return $this->getComponentText('Missing user play_id');
        }

        $profilepic = $content['profilepic'] ? $content['profilepic'] : 'icon_camera-grey.png';

        $width = $this->screen_width;

        if(isset($parameters['bottom_menu']) AND $parameters['bottom_menu']){
            $height = $this->screen_height - 60;
        } else {
            $height = $this->screen_height;
        }

        $col[] = $this->getComponentImage($profilepic,[
            'imgwidth' => '1200',
            'onclick' => $this->uiKitOpenProfile($id),
            'click_hilite' => 'none',
            'priority' => '9'],[
                'crop' => 'yes',
                'width' => $width,
                'height' => $height]);

        $name = isset($content['firstname']) ? $content['firstname'] : '{#anonymous#}';

        if(isset($content['age']) AND $content['age']){
            $name .= ', '.$content['age'];
        } elseif(isset($content['birth_year'])){
            $name .= ', ' .date('Y') - $content['birth_year'];
        }

        /*    "shadow-color" : "#B2B4B3",
    "shadow-radius": "1",
    "shadow-offset": "0 0",
*/

        $row[] = $this->getComponentText($name,[],[
            'color' => '#ffffff',
            'shadow-color' => '#000000',
            'shadow-radius' => 1,
            'shadow-offset' => '0 0',
            'padding' => '2 2 2 2',
            'font-size' => 28
        ]);

        if(isset($content['instagram_username']) AND $content['instagram_username']){
            $row[] = $this->getComponentImage('uikit_swipe_insta.png',[
                'style' => 'ukit_user_swiper_insta',
                'onclick' => $this->getOnclickOpenUrl('https://instagram.com/'.$content['instagram_username']),
                'hide_when_swiping' => 1
                ],[
                    'background-color' => '#ffffff','height' => '40',
                'padding' => '5 5 5 5','border-radius' => '6','margin' => '10 0 0 0'
            ]);
        }

        $layout = new \stdClass();
        $layout->top = 45;
        $layout->center = 0;

        $overlay = $this->getComponentColumn($row,['layout' => $layout],[
            'padding' => '10 5 10 5',
            'vertical-align' => 'middle',
            'text-align' => 'center',
            'width' => '100%']);

        /* setting the controls */
        if(isset($content['bookmark']) AND $content['bookmark']){
            $params['is_bookmarked'] = true;
        }

        $params['id'] = $id;
        $layout = new \stdClass();
        $layout->bottom = 60;
        $layout->left = 15;
        $layout->right = 15;
        $params['layout'] = $layout;
        $params['shadow'] = true;
        $overlay2 = $this->uiKitUserSwiperControls($params);

        $layout = new \stdClass();
        $layout->bottom = 0;
        $layout->left = 0;
        $layout->right = 0;


        /* optional shader */
/*        $shadeheight = round($this->screen_width * 0.2,0);

        $shader_img = $this->getImageFileName('blue-gradient.png');

        $shader = $this->getComponentText('',['layout' => $layout],[
            'height' => $shadeheight,
            'width' => '100%',
            'background-image' => $shader_img,
            "background-size" => "cover",
            //"background-linear-color" => "180deg,ffffff 0%,008596 100%"
        ]);*/


        $out[] = $this->getComponentColumn($col, array(
            'style' => 'ukit_user_swiper_full_screen','overlay' => [$overlay,$overlay2]
        ));


        //die();
        $out2[] = $this->getComponentColumn($out,[
            'leftswipeid' => 'left' . $id,
            'rightswipeid' => 'right' . $id,
        ],['text-align' => 'center','width' => '100%']);


        return $this->getComponentColumn($out2);

    }

}