<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

trait uiKitThreeColumnImageSwiper {


    public function uiKitThreeColumnImageSwiper(array $images, array $params=array()){

        $otherItemsRow = array();
        $count = 0;
        $width = $this->screen_width - 30 - 24;
        $width = $width / 3;
        $otherItemsRow[] = $this->getComponentVerticalSpacer('8');

        foreach ($images as $item) {
            $onclick = new \stdClass();
            $onclick->action = 'open-action';
            $onclick->action_config = $this->model->getActionidByPermaname('itemdetail');
            $onclick->sync_open = 1;
            $onclick->id = $item['id'];

            if($item['image']){
                $otherItemsRow[] = $this->getComponentImage($item['image'], array(
                    'onclick' => $onclick,
                    'imgwidth' => '250',
                    'imgheight' => '250',
                    'priority' => '9',
                    'lazy' => '1'
                ), array(
                    'width' => $width,
                    'height' => $width,
                    'crop' => 'yes',
                    'margin' => '0 8 0 0',
                    'border-radius' => '3',
                ));
            }


            $count++;
            if($count == 3){
                $output[] = $this->getComponentRow($otherItemsRow, array(), array('padding' => '10 10 10 10','margin' => '0 0 0 0'));
                unset($otherItemsRow);
                $otherItemsRow[] = $this->getComponentVerticalSpacer('8');
                $count = 0;
            }
        }

        if(isset($otherItemsRow)){
            $output[] = $this->getComponentRow($otherItemsRow, array(), array('padding' => '10 10 10 10','margin' => '0 0 0 0'));
        }

        if(isset($output)){
            $col[] = $this->getComponentSwipe($output,array('id' => 'additional'));
            $col[] = $this->getComponentSwipeAreaNavigation('#545050','#E1E4E3',array('swipe_id' => 'additional'));
        } else {
            $col[] = $this->uiKitDivider();
        }

        return $this->getComponentColumn($col,array(),array('text-align' => 'center'));

    }



}