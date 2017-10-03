<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;
use function strtoupper;

trait SwipeNavi {

    /**
     * @param $content string, no support for line feeds
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
     * 'crop' => 'round', // or 'yes'
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

    public function getComponentSwipeNavi(int $totalcount, int $currentitem, $color = 'white', $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        $count = 1;
        $row = array();

        if($color == 'white'){
            $color_normal = "#80ffffff";
            $color_selected = "#ffffff";
        } else {
            $color_normal = "#4D000000";
            $color_selected = "#000000";
        }

        while($count <= $totalcount){

            if($count == 1){
                $margin = '0 0 0 0';
            } else {
                $margin = '0 0 0 3';
            }

            if($count == $currentitem){
                $row[] = $this->getComponentText('•',array(),array('color' => $color_selected,'font-size' => '27','width' => '14','text-align' => 'center','margin' => $margin));
            } else {
                $row[] = $this->getComponentText('•',array(),array('color' => $color_normal,'font-size' => '27','width' => '14','text-align' => 'center','margin' => $margin));
            }

            $count++;
        }

        $obj = $this->getComponentRow($row,array(),array_merge(array('width' => '100%', 'text-align' => 'center'), $styles));

        return $obj;
    }

}