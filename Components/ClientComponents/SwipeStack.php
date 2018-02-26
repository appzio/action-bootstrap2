<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait SwipeStack {

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

    public function getComponentSwipeStack(array $pages, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        $obj = new \stdClass();
        $obj->type = 'swipestack';
        $obj->swipe_content = $pages;

        $allowed = array(
            'swipe_content',
            'overlay_left',
            'overlay_right',
            'rightswipeid',
            'leftswipeid',
            'backswipeid',
            'swipe_back_content',
            'id',
            'transition',
            'world_ending'
        );

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters,$allowed);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}