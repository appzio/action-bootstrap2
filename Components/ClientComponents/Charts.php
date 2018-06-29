<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait Charts {

    /**
     * @param $id string
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
    public function getComponentLinechart(array $data, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        /* {"type": "chart-line", "style_content":{"height":"200"}, "sets":[
   {"name":"1 Set", "style_content":{"color":"FF00FF"},"points":[{"x":0,"y":10},{"x":1,"y":20}]},
   {"name":"2 Set", "style_content":{"color":"00FF00"},"points":[{"x":0,"y":15},{"x":1,"y":21}]}]}
*/

        $obj = new \StdClass;
        $obj->type = 'chart-line';
        $obj->label = 'My usage';
        $obj->sets = $data;

        if(isset($parameters['names'])){
            $obj->x_names = $parameters['names'];
        }

        if(isset($parameters['no_values'])){
            $obj->no_values = 1;
        }

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

    public function getComponentBarchart(array $data, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        /* {"type": "chart-line", "style_content":{"height":"200"}, "sets":[
   {"name":"1 Set", "style_content":{"color":"FF00FF"},"points":[{"x":0,"y":10},{"x":1,"y":20}]},
   {"name":"2 Set", "style_content":{"color":"00FF00"},"points":[{"x":0,"y":15},{"x":1,"y":21}]}]}
*/
        $obj = new \StdClass;
        $obj->type = 'chart-bar';
        $obj->label = 'My usage';
        $obj->sets = $data;

        if(isset($parameters['names'])){
            $obj->x_names = $parameters['names'];
        }

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

    public function getComponentPiechart(array $data, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        /* {"type": "chart-line", "style_content":{"height":"200"}, "sets":[
   {"name":"1 Set", "style_content":{"color":"FF00FF"},"points":[{"x":0,"y":10},{"x":1,"y":20}]},
   {"name":"2 Set", "style_content":{"color":"00FF00"},"points":[{"x":0,"y":15},{"x":1,"y":21}]}]}
*/
        $obj = new \StdClass;
        $obj->type = 'chart-pie';
        $obj->label = 'My usage';
        $obj->sets = $data;

        if(isset($parameters['names'])){
            $obj->x_names = $parameters['names'];
        }

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}