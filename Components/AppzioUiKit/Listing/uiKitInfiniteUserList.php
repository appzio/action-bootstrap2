<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Components\BootstrapComponent;

trait uiKitInfiniteUserList {

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

    public function uiKitInfiniteUserList($content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        if(!is_array($content) OR empty($content)){
            return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        }

        $count = 0;

        foreach($content as $item){
            $swiper[] = $this->getFeaturedUserForList($item);
            $count++;
        }

        if(isset($swiper)){
            $out[] = $this->getComponentColumn(
                $swiper,
                array(
                    'id' => 'swipe_container'
                ),[]);
            return $this->getComponentColumn($out);
        }

        return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        
    }

	private function getFeaturedUserForList($content){

        $id = isset($content['play_id']) ? $content['play_id'] : false;

        if(!$id){
            return $this->getComponentText('Missing user play_id');
        }

        $profilepic = $content['profilepic'] ? $content['profilepic'] : 'icon_camera-grey.png';
        $name = isset($content['firstname']) ? $content['firstname'] : '{#anonymous#}';

        if(isset($content['age']) AND $content['age']){
            $name .= ', ' .$content['age'];
        } elseif(isset($content['birth_year'])){
            $name .= ', ' .date('Y') - $content['birth_year'];
        }

        $location = 'Startbux Porto';

        $row[] = $this->getComponentImage($profilepic, [
            'imgwidth' => '150',
            'imgheight' => '150',
            'onclick' => $this->uiKitOpenProfile($id)
        ],[
            'crop' => 'round',
            'margin' => '10 10 10 10',
            'height' => '35',
            'width' => '35'
        ]);

        $subcol[] = $this->getComponentText($name,[],['font-size' => '16']);
        $subcol[] = $this->getComponentText($location,[],['font-size' => '14']);

        $row[] = $this->getComponentColumn($subcol,[],['vertical-align' => 'middle']);

        $row[] = $this->getComponentText('{#hide#}',[
            'onclick' => $this->getOnclickHideElement('user_'.$id)
        ],[
            'floating' => 1,'float' => 'right', 'margin' => '7 15 7 0',
            'font-size' => '14','border-width' => 1,'border-color' => "#7A7474",'color' => '#7A7474','border-radius' => '4',
            'height' => '25', 'padding' => '0 15 0 15']);

        $col[] = $this->getComponentRow($row,[],['vertical-align' => 'middle']);

        unset($row);

        $width = $this->screen_width;
        $height = round($this->screen_width/1.4,0);

        $col[] = $this->getComponentImage($profilepic,[
            'imgwidth' => 900,
            'imgheight' => 650,
            'onclick' => $this->uiKitOpenProfile($id),
            'priority' => '9'],[
                'crop' => 'yes',
                'width' => $width,
                'height' => $height]);



        $row[] = $this->getComponentText($name,['style'=>'ukit_user_swiper_name']);

        if(isset($content['instagram_username']) AND $content['instagram_username']){
            $row[] = $this->getComponentImage('uikit_swipe_insta.png',['style' => 'ukit_user_swiper_insta',
                'onclick' => $this->getOnclickOpenUrl('https://instagram.com/'.$content['instagram_username'])]);
        }

        $col[] = $this->getComponentRow($row,[],['margin' => '0 0 0 0']);


        $out[] = $this->getComponentColumn($col, array(

        ));

        $out2[] = $this->getComponentColumn($out,[
            'leftswipeid' => 'left' . $id,
            'rightswipeid' => 'right' . $id,
        ],['text-align' => 'center','width' => '100%','padding' => '0 0 0 0 ']);

        if(isset($content['bookmark']) AND $content['bookmark']){
            $params['is_bookmarked'] = true;
        }

        $params['id'] = $id;

        $out2[] = $this->uiKitUserSwiperControls($params);
        return $this->getComponentColumn($out2,['id' => 'user_'.$id]);

    }

}