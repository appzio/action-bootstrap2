<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

trait uiKitFullWidthImageSwiper
{


    public function uiKitFullWidthImageSwiper(array $images, array $params = array(), $styles = array())
    {

        $height = round($this->screen_width / 1.25, 0);

        $id = isset($params['id']) ? $params['id'] : 'photos';
        $swipe_navi = isset($params['navi_location']) ? $params['navi_location'] : 'bottom';
        $height = $this->addParam('height', $styles, $height);

        $params['imgwidth'] = '900';
        $params['imgheight'] = '720';
        $params['imgcrop'] = 'yes';
        $params['priority'] = '9';
        $params['not_to_assetlist'] = true;
        $params['tap_to_open'] = 1;
        $params['click_hilite'] = 'none';

        $image_styles['width'] = $this->screen_width;
        $image_styles['height'] = $height;
        $image_styles['not_to_assetlist'] = true;
        $image_styles['priority'] = '9';
        $image_styles['crop'] = 'yes';

        $navi_styles['margin'] = '-60 0 0 0';
        $navi_styles['text-align'] = 'center';

        $content = array();
        $current = 1;

        foreach ($images as $image) {
            if($image){
                $content[] = $this->getComponentColumn(array(
                    $this->getComponentImage($image, $params, $image_styles),
                ));
            }

            $current++;
        }

        $output[] = $this->getComponentSwipe($content, array('id' => $id));

        if ($swipe_navi == 'bottom' AND count($images) > 1) {
            $col[] = $this->getComponentSwipeAreaNavigation('#ffffff', '#66ffffff', array('swipe_id' => $id));
            $output[] = $this->getComponentColumn($col, array(), array('height' => '50', 'margin' => '-50 0 0 0', 'text-align' => 'center'));
        }

        return $this->getComponentColumn($output);

    }


}