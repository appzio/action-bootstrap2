<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait SwipeNavi {

    /**
     * @param $totalcount int
     * @param $currentitem int
     * @param $color string
     * @param $parameters array selected_state, variable, onclick, style
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