<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Spacers {

    /**
     * Shows a simple loader element (spinning wheel)
     *
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'style' => 'style-class-name',
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */

    public function getComponentSpacer($height = 10, array $parameters=array(),array $styles=array()) {

        $obj = $this->getComponentText('', array(), array(
            'height' => $height
        ));

        return $obj;
	}

    public function getComponentVerticalSpacer($width = 10, array $parameters=array(),array $styles=array()) {

        $obj = $this->getComponentText('', array(), array(
            'width' => $width
        ));

        return $obj;
    }


}