<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitTopbar
{

	public $corner_size = 6;

	public function uiKitTopbar($image, $title, $custom_styles = array()) {
        /** @var BootstrapComponent $this */

        $styles = array(
			'width' => $this->screen_width,
			'padding' => '10 10 10 10',
			'vertical-align' => 'middle',
		);

        if ( !empty($custom_styles) ) {
        	$styles = array_merge($styles, $custom_styles);
        }

        return $this->getComponentRow(array(
	        $this->getComponentColumn(array(
		        $this->getComponentImage($image, array(), array(
			        'width' => '30'
		        )),
	        ), array(
		        'onclick' => $this->getOnclickGoHome(),
	        ), array(
		        'width' => $this->screen_width / $this->corner_size
	        )),
	        $this->getComponentColumn(array(
	        	$this->getComponentText($title, array(), array(
			        'font-size' => '20',
		        )),
	        ), array(), array(
		        'text-align' => 'center',
		        'width' => $this->screen_width - (2 * ($this->screen_width / $this->corner_size))
	        )),
        ), array(), $styles);
    }

}