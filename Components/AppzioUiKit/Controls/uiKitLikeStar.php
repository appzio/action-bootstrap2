<?php

namespace Bootstrap\Components\AppzioUiKit\Controls;
use Bootstrap\Views\BootstrapView;

trait uiKitLikeStar {

    /**
     * Simple like / unlike star which works in async fashion. Provide controller
     * methods for saving the like & unlike (these functions should have $this->no_output = true; set
     * in order not to make the clien refresh.
     * @param bool $liked
     * 1 or 2 whether the item is liked or not
     * @param $action_like
     * Full path, ie Controller/like/$id
     * @param $action_unlike
     * Full path, ie Controller/unlike/$id
     * @height int $height
     * Height of the element
     * @id int $id
     * This is an optional id value, which should be set to unique value when you have several items in the same view
     */

    public function uiKitLikeStar(bool $liked=false, string $action_like, string $action_unlike,int $height=40,int $id=0){

        $onclick_like[] = $this->getOnclickShowElement('star_liked'.$id,array('transition' => 'none'));
        $onclick_like[] = $this->getOnclickHideElement('star_unliked'.$id,array('transition' => 'none'));
        $onclick_like[] = $this->getOnclickSubmit($action_like,array('loader_off' => true));

        $onclick_unlike[] = $this->getOnclickShowElement('star_unliked'.$id,array('transition' => 'none'));
        $onclick_unlike[] = $this->getOnclickHideElement('star_liked'.$id,array('transition' => 'none'));
        $onclick_unlike[] = $this->getOnclickSubmit($action_unlike,array('loader_off' => true));

        $params['imgwidth'] = '80';
        $params['imgheight'] = '80';

        $params_liked = $params;
        $params_liked['onclick'] = $onclick_unlike;
        $params_liked['id'] = 'star_liked'.$id;

        $params_unliked = $params;
        $params_unliked['onclick'] = $onclick_like;
        $params_unliked['id'] = 'star_unliked'.$id;

        if($liked){
            $params_unliked['visibility'] = 'hidden';
        } else {
            $params_liked['visibility'] = 'hidden';
        }

        $style_liked = array('width' => $height);
        $style_unliked = array('width' => $height);

        $star[] = $this->getComponentImage('uikit-star-liked.png',$params_liked,$style_liked);
        $star[] = $this->getComponentImage('uikit-star-unliked.png',$params_unliked,$style_unliked);

        return $this->getComponentColumn($star,array(),array('height' => $height));
    }


}