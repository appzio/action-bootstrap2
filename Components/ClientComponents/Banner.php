<?php
/**
 * Trait Banner
 * @link https://google.com
 * @package Bootstrap\Components\Elements
 */

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Banner {

    /**
     *
     * Returns an advertising banner (Google or AdColony depending on configuration)
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