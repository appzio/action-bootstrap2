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

        $page = isset($_REQUEST['next_page_id']) ? $_REQUEST['next_page_id'] : 1;
        $page++;
        $count = 0;

        foreach($content as $item){
            $swiper[] = $this->getFeaturedUserForList($item,$parameters);
            $count++;
        }

        if(isset($swiper)){
            $out[] = $this->getComponentColumn(
                $swiper,
                array(
                    'id' => 'swipe_container'
                ),[]);

            return $this->getInfiniteScroll($out,array('next_page_id' => $page));
        }

        return $this->getComponentText('{#no_users_found_at_the_monent#}',array('style' => 'steps_error2'));
        
    }

	private function getFeaturedUserForList($content,$parameters){

        $id = isset($content['play_id']) ? $content['play_id'] : false;

        if(!$id){
            return $this->getComponentText('Missing user play_id');
        }

        $profilepic = $content['profilepic'] ? $content['profilepic'] : 'icon_camera-grey.png';
        $profilepic2 = $content['profilepic2'] ? $content['profilepic2'] : false;
        $profilepic3 = $content['profilepic3'] ? $content['profilepic3'] : false;
        $profilepic4 = $content['profilepic4'] ? $content['profilepic4'] : false;
        $profilepic5 = $content['profilepic5'] ? $content['profilepic5'] : false;
        $name = isset($content['firstname']) ? $content['firstname'] : '{#anonymous#}';
        $unlikeaction = isset($parameters['unlike_action']) ? $parameters['unlike_action'] : 'infinite/unlike/'.$id;
        $likeaction = isset($parameters['likeaction']) ? $parameters['likeaction'] : 'infinite/like/'.$id;

        $dolike[] = $this->getOnclickHideElement('user_'.$id);
        $dolike[] = $this->getOnclickSubmit($likeaction);

        $dounlike[] = $this->getOnclickHideElement('user_'.$id);
        $dounlike[] = $this->getOnclickSubmit($unlikeaction);

        $bookmark[] = $this->getOnclickHideElement('bookmark_not_active'.$id,['transition' => 'none']);
        $bookmark[] = $this->getOnclickShowElement('bookmark_active'.$id,['transition' => 'none']);
        $bookmark[] = $this->getOnclickSubmit('controller/bookmark/'.$id,['loader_off' => true]);

        $un_bookmark[] = $this->getOnclickShowElement('bookmark_not_active'.$id,['transition' => 'none']);
        $un_bookmark[] = $this->getOnclickHideElement('bookmark_active'.$id,['transition' => 'none']);
        $un_bookmark[] = $this->getOnclickSubmit('controller/removebookmark/'.$id,['loader_off' => true]);

        if(isset($content['age']) AND $content['age']){
            $name .= ', ' .$content['age'];
        } elseif(isset($content['birth_year'])){
            $name .= ', ' .date('Y') - $content['birth_year'];
        }

        if(isset($content['current_venue']) AND $content['current_venue']){
            $location = $content['current_venue'];
        } else {
            $location = '';
        }
        
        /* top row */
        $col[] = $this->getComponentRow([
            $this->getComponentImage($profilepic, [
                'imgwidth' => '150',
                'imgheight' => '150',
                'onclick' => $this->uiKitOpenProfile($id)],[
                    'crop' => 'round',
                    'margin' => '10 10 10 10',
                    'height' => '35',
                    'width' => '35'
            ]),
            $this->getComponentColumn(
                [
                    $this->getComponentText($name,[],['font-size' => '16']),
                    $this->getComponentText($location,[],['font-size' => '14'])
                ],[],['vertical-align' => 'middle']),

            $this->getComponentText('{#hide#}',[
                'onclick' => $dounlike,
            'style' => 'uikit_list_hide_button'])

        ],[],['vertical-align' => 'middle']
        );

        $width = $this->screen_width;
        $height = round($this->screen_width/1.4,0);

        if($profilepic2){
            $pics[] = $this->getComponentImage($profilepic,[
                'imgwidth' => 900,
                'imgheight' => 650,
                'onclick' => $this->uiKitOpenProfile($id),
                'priority' => '9'],[
                'crop' => 'yes',
                'width' => $width,
                'height' => $height]);

            $pics[] = $this->getComponentImage($profilepic2,[
                'imgwidth' => 900,
                'imgheight' => 650,
                'onclick' => $this->uiKitOpenProfile($id),
                'priority' => '9'],[
                'crop' => 'yes',
                'width' => $width,
                'height' => $height]);

            if($profilepic3){
                $pics[] = $this->getComponentImage($profilepic3,[
                    'imgwidth' => 900,
                    'imgheight' => 650,
                    'onclick' => $this->uiKitOpenProfile($id),
                    'priority' => '9'],[
                    'crop' => 'yes',
                    'width' => $width,
                    'height' => $height]);
            }

            $col[] = $this->getComponentSwipe($pics);
            $col[] = $this->getComponentSwipeAreaNavigation('#00BED2','#E4E7E9',[],
                ['margin' => '-30 0 0 0','text-align' => 'center', 'width' => '100%']);



        } else {
            $col[] = $this->getComponentImage($profilepic,[
                'imgwidth' => 900,
                'imgheight' => 650,
                'onclick' => $this->uiKitOpenProfile($id),
                'priority' => '9'],[
                'crop' => 'yes',
                'width' => $width,
                'height' => $height]);
        }



        $width = $this->screen_width - 140;


        /* bottom buttons */


        $controls[] = $this->getComponentImage('uikit-icon-black-heart.png',[
            'onclick' => $dolike
        ],[
            'width' => '40','margin' => '5 15 5 15'
        ]);

        if(isset($content['instagram_username']) AND $content['instagram_username']){

            $controls[] = $this->getComponentRow([
                $this->getComponentText('{#follow#}',['style' => 'uikit_list_follow_button',
                    'onclick' => $this->getOnclickOpenUrl('https://instagram.com/'.$content['instagram_username'])])
            ],[],['width' => $width,'text-align' => 'center']);
        } else {
            $controls[] = $this->getComponentRow([
                $this->getComponentText('',['style' => 'uikit_list_follow_placeholder'])],
                    [],['width' => $width,'text-align' => 'center']);
        }


        if(isset($content['bookmark']) AND $content['bookmark']) {
            $controls[] = $this->getComponentImage('uikit-icon-ribbon-hollow.png',[
                'visibility' => 'hidden','id' => 'bookmark_not_active'.$id,'onclick' => $bookmark
            ],[
                'width' => '40','margin' => '5 15 5 15'
            ]);

            $controls[] = $this->getComponentImage('uikit-icon-ribbon-orange.png',[
                'id' => 'bookmark_active'.$id,'onclick' => $un_bookmark
            ],[
                'width' => '40','margin' => '5 15 5 15'
            ]);
        } else {
            $controls[] = $this->getComponentImage('uikit-icon-ribbon-hollow.png',[
                'id' => 'bookmark_not_active'.$id,'onclick' => $bookmark
            ],[
                'width' => '40','margin' => '5 15 5 15'
            ]);

            $controls[] = $this->getComponentImage('uikit-icon-ribbon-orange.png',[
                'visibility' => 'hidden','id' => 'bookmark_active'.$id,'onclick' => $un_bookmark
            ],[
                'width' => '40','margin' => '5 15 5 15'
            ]);
        }

        $col[] = $this->getComponentRow($controls,[],['width' => '100%','vertical-align' => 'middle']);


        $col[] = $this->getComponentDivider();

        return $this->getComponentColumn($col,['id' => 'user_'.$id],['margin' => '0 0 10 0']);

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