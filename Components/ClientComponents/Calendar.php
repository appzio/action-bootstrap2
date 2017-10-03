<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait Calendar
 * @package Bootstrap\Components\Elements
 */
trait Calendar {

    /**
     * @param $content string, no support for line feeds
     * @param array $parameters date,
     * <code>
     * $array = array(
     * 'date' => '337651200', // unix time
     * 'variable'   => 'variablename',
     * 'selection_style' => $onclick, // this must be an object
     * 'style' => 'style-class-name',
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */

    public function getComponentCalendar(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

		$obj = new \StdClass;
        $obj->type = 'calendar';

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}