<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait Fieldlist
 * @package Bootstrap\Components\Elements
 */
trait Timer {

    /**
     * @param $content array of other objects
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'rightswipeid' => 'item-id-rightswipe',  // this is a compound of item id & action of swipe right
     * 'leftswipeid'   => 'item-id-leftswipe', // this is a compound of item id & action of swipe left
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'id' => 'mycustomid',
     * 'swipe_id' => 'swipeareaid' // refers to swipearea in the view
     * );
     * </code>
     * @param array $styles
     * <code>
     * $array = array(
     * 'margin' => '0 0 0 0',
     * 'padding' => '0 0 0 0',
     * 'width' => '200', // or 100%
     * 'height' => '400',
     * 'max_height' => '500',
     * 'background-color' => '#ffffff',
     * 'background-image' => 'filename.png',
     * 'background-size' => 'cover', // or 'contain', 'top' (default)
     * 'vertical-align' => 'middle',
     * 'text-align' => 'center',
     * 'children_style' => 'style-class-name' // this is used only in menu, progress and field-list components
     * 'floating' => '1',
     * 'float' => 'right',
     * 'parent_style' => 'style-class-name',
     * 'shadow-color' => '#000000',
     * 'shadow-offset' => '0 1',
     * 'shadow-radius' => '5',
     * 'border-width' => '1',
     * 'border-color' => '#000000',
     * 'border-radius' => '4',
     * 'opacity' => '0.4',
     * );
     * </code>
     * @return \stdClass
     */
    public function getTimer(string $content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

		$obj = new \StdClass;
        $obj->type = 'timer';
        $obj->content = $content;

        $required = array('timer_id','mode','submit_menu_id');
        
        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters,array(),$required);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}