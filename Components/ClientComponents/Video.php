<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Video {

    /**
     * @param $content string, no support for line feeds
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'repeat' => 'style-class-name',
     * 'autostart'   => 'variablename',
     * 'showplayer' => $onclick, // this must be an object or an array of objects
     * 'loop' => 'style-class-name',
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */
    public function getComponentVideo(string $content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        $obj = new \StdClass;
        $obj->type = 'video';
        $obj->content = $content;

        $allowed = array('repeat', 'autostart', 'showplayer', 'loop');

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters,$allowed);
        $obj = $this->configureDefaults($obj);

        return $obj;
    }

}


