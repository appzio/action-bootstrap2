<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

trait uiKitFullWidthImageSwiper {


    public function uiKitFullWidthImageSwiper(array $images, array $params=array()){

        $height = round($this->screen_width / 1.25, 0);

        $id = isset($params['id']) ? $params['id'] : 'photos';

        $params['imgwidth'] = '900';
        $params['imgheight'] = '720';
        $params['imgcrop'] = 'yes';
        $params['priority'] = '9';
        $params['not_to_assetlist'] = true;
        $params['tap_to_open'] = 1;

        $image_styles['width'] = $this->screen_width;
        $image_styles['height'] = $height;
        $image_styles['not_to_assetlist'] = true;
        $image_styles['priority'] = '9';

        $navi_styles['margin'] = '-60 0 0 0';
        $navi_styles['text-align'] = 'center';

        $content = array();
        $current = 1;

        foreach ($images as $image) {
            $content[] = $this->getComponentColumn(array(
                $this->getComponentImage($image, $params, $image_styles),
            ));

            $current++;
        }

        $output[] = $this->getComponentSwipe($content,array('id' => $id));
        $col[] = $this->getComponentSwipeAreaNavigation('#ffffff','#66ffffff',array('swipe_id' => $id));
        $output[] = $this->getComponentColumn($col,array(),array('height' => '40', 'margin' => '-40 0 0 0','text-align' => 'center'));

        return $this->getComponentColumn($output);

    }



}