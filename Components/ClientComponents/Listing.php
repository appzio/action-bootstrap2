<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Listing {

    /**
     * This is a listing component for higher performance lists. It takes data and layout separately.
     * Inside the layout you can refer to data with variables. Ie. $name for example.
     * @param array $data named array of data
     * @param \stdClass $placeholder layout code
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */
    public function getComponentList(array $data, \stdClass $layout,$parameters=array(),$styles=array()) {
        /** @var BootstrapView $this */

		$obj = new \StdClass;
        $obj->type = 'list';
        $obj->data = $data;
        $obj->placeholder = $layout;

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}