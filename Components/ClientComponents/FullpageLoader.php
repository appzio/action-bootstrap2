<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait FullpageLoader {

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

    public function getComponentFullPageLoader(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        $color = isset($parameters['color']) ? $parameters['color'] : '#000000';
        $text = isset($parameters['text']) ? $parameters['text'] : '{#loading#}';

        $col[] = $this->getComponentSpacer('80');
        $col[] = $this->getComponentLoader(array(),array('color' => $color));
        $col[] = $this->getComponentText($text,array('style' => 'loader-text'));

        return $this->getComponentColumn($col,array('text-align' => 'center','width' => '100%','align' => 'center'));

    }

}