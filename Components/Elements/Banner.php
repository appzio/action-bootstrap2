<?php

namespace Bootstrap\Components\Elements;
use Bootstrap\Views\BootstrapView;

trait Banner {

    /**
     * @param $advertisingid -- should be the adid from Google or AdColony
     * @param string $size -- banner | rectangle
     * @return \StdClass
     */

    public function getBannerAd($advertisingid, $size='banner') {
        /** @var BootstrapView $this */
		$obj = new \StdClass;
        $obj->action = 'ad';
        $obj->action_config = $advertisingid;
        $obj->ad_size = $size;
        return $obj;
	}

}