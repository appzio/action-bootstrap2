<?php

namespace Bootstrap\Components\AppzioUiKit\Fullviews;

trait uiKitIntroWithButtons {


    public function uiKitIntroWithButtons(array $items, array $params=array()){


        foreach ($items as $item){
            $swipe[] = $this->uiKitIntroWithButtonsGetItem($item);
        }

        if(isset($swipe)){
            $col[] = $this->getComponentSwipe($swipe,array('dynamic' => 1),array());
            return $this->getComponentColumn($col);
        }

        return $this->getComponentText('no items');

    }


    public function uiKitIntroWithButtonsGetItem($item){

        if(isset($item['icon'])){
            $icon[] = $this->getComponentImage($item['icon'],array('style' => 'uikit_intro_icon'));
            $col[] = $this->getComponentColumn($icon,array(),array('text-align' => 'center','margin' => '40 0 20 0'));
        }

        if(isset($item['title'])){
            $col[] = $this->getComponentText($item['title'],array('style' => 'uikit_intro_title'));
        }

        if(isset($item['description'])){
            $col[] = $this->getComponentText($item['description'],array('style' => 'uikit_intro_description'));
        }

        if(isset($item['buttons'])){
            $col[] = $this->getComponentSpacer('120');

            if(count($item['buttons']) == 1 AND isset($item['buttons'][0]['title']) AND isset($item['buttons'][0]['onclick'])){
                $col[] = $this->uiKitButtonFilled($item['buttons'][0]['title'],array('onclick' => $item['buttons'][0]['onclick'],
                    'noanimate' => true));
            } elseif(count($item['buttons']) == 2){
                $col[] = $this->uiKitDoubleButtons($item['buttons'][0]['title'],$item['buttons'][1]['title'],
                    array('onclick' => $item['buttons'][0]['onclick'],'back_button' => 1),
                    array('onclick' => $item['buttons'][1]['onclick'],'back_button' => 1),
                    array(),array(),'#F0F3F8');
            }
        }



            if(isset($col)){
            return $this->getComponentColumn($col,array(),array('height' => $this->screen_height - 80));
        } else {
            return $this->getComponentText('no info');
        }
        
        

    }





}