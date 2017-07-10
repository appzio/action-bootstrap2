<?php

namespace Bootstrap\Components\Elements;
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
     * 'font-size' => '14',
     * 'font-ios' => 'Roboto',
     * 'font-weight' => 'Bold',
     * 'font-style' => 'Italic',
     * 'font-android' => 'Roboto',
     * 'color' => '#000000',
     * 'white-space' => 'nowrap',
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