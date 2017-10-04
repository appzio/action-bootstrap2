<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Swipe {

    /**
     * @param $pages array
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'selected_state' => 'style-class-name',
     * 'variable'   => 'variablename',
     * 'uppercase' => '1' // transform to uppercase
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'style' => 'style-class-name',
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */

    public function getComponentSwipe(array $pages, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

		$obj = new \StdClass;
        $obj->type = 'swipe';
        $obj->swipe_content = $pages;

        $allowed = array(
            'swipe_content', 'text_content', 'progress_image', 'track_image','animate','remember_position','position',
            'item_width','dynamic','id','items','animation','container_id','item_scale','transition','world_ending',
            'hide_scrollbar'
        );

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters,$allowed);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}