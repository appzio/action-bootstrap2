<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait RichText {

	/**
	 * @param $content array, no support for line feeds
	 * @param array $parameters onclick, style
	 * <code>
	 * $array = array(
	 * 'uppercase' => '1' // transform to uppercase
	 * 'onclick' => $onclick, // this must be an object or an array of objects
	 * 'style' => 'style-class-name',
	 * );
	 * </code>
	 * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
	 * @return \stdClass
	 */
	public function getComponentRichText(array $content, array $parameters=array(),array $styles=array()) {
		/** @var BootstrapView $this */

		$obj = new \StdClass;
		$obj->type = 'rich-text';
		$obj->items = $content;

		$obj = $this->attachStyles($obj,$styles);
		$obj = $this->attachParameters($obj,$parameters);

		return $obj;
	}

}