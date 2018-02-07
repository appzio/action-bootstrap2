<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitTopbar
{

	public $corner_size = 6;

	public function uiKitTopbar($image, $title, $onclick = false, $custom_styles = array()) {
        /** @var BootstrapComponent $this */

        if ( empty($onclick) ) {
	        $onclick = $this->getOnclickGoHome();
        }

        $styles = array(
			'width' => $this->screen_width,
			'padding' => '0 15 0 15',
			'height' => '50',
			'vertical-align' => 'middle',
		);

        if ( !empty($custom_styles) ) {
        	$styles = array_merge($styles, $custom_styles);
        }

        return $this->getComponentRow(array(
	        $this->getComponentColumn(array(
		        $this->getComponentImage($image, array(), array(
			        'height' => '25',
		        )),
	        ), array(
		        'onclick' => $onclick,
	        ), array(
		        'width' => $this->screen_width / $this->corner_size,
	        	'text-align' => 'left',
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