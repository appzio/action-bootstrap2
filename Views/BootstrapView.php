<?php

namespace Bootstrap\Views;

use Bootstrap\Components\BootstrapComponent;
use Bootstrap\Components\ComponentHelpers;
use Bootstrap\Components\Elements as Elements;
use function defined;
use function is_array;
use function is_bool;
use function is_float;
use function is_int;
use function is_object;
use function is_string;
use function property_exists;
use stdClass;

class BootstrapView extends BootstrapComponent implements BootstrapViewInterface   {

    use ViewHelpers;
    use ViewGetters;

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
    public $phpstorm_bugfix;

    /* @var \Bootstrap\Controllers\BootstrapController */
    //public $controller;

    /* @var \Bootstrap\Models\BootstrapModel */
    public $model;

    /* @var \Bootstrap\Components\BootstrapComponent */
    public $components;

    public $colors;

    public $menuid;
    public $actionid;

    /* data sent by the controller */
    protected $data;

    /* layout code */
    public $layout;

    public $color_text_color;
    public $color_icon_color;
    public $color_background_color;
    public $color_button_text;
    public $color_dark_button_text;
    public $color_top_bar_text_color;
    public $color_top_bar_icon_color;
    public $color_button_more_info_color;
    public $color_button_more_info_icon_color;
    public $color_button_more_info_text_color;
    public $color_item_text_color;
    public $color_top_bar_color;
    public $color_button_color;
    public $color_item_color;
    public $color_button_icon_color;
    public $color_button_text_color;
    public $color_side_menu_color;
    public $color_side_menu_text_color;

    /*Array ( [text_color] => #FF000000 [icon_color] => #FF000000 [background_color] => #FFCFD8DC [button_text] => #FF000000
    [dark_button_text] => #FFFFFFFF [top_bar_text_color] => #FFFFFFFF [top_bar_icon_color] => #FFFFFFFF
    [button_more_info_color] => #FF000000 [button_more_info_icon] => #FFFFFFFF [button_more_info_icon_color] => #FFFFFFFF
    [button_more_info_text_color] => #FFFFFFFF [item_text_color] => #FFFFFFFF [top_bar_color] => #FFD32F2F
    [button_color] => #FF536DFE [item_color] => #FFFFCDD2 [button_icon_color] => #FFFFFFFF
     [button_text_color] => #FFFFFFFF [side_menu_color] => #FFFFFFFF [side_menu_text_color] => #FF000000 )*/

    public function __construct($obj){

        while($n = each($this)){
            $key = $n['key'];
            if(isset($obj->$key) AND !$this->$key){
                $this->$key = $obj->$key;
            }
        }

        $this->data = new \stdClass();

        /* set colors */
        foreach($this->colors as $name=>$color){
            $name = 'color_'.$name;

            if(property_exists($this,$name)){
                $this->$name = $color;
            }
        }
    }

    public function setError(string $msg){
        $this->errors[] = $msg;
    }

    public function tab1(){
        $this->data = new \stdClass();
        $this->data->header = array();
        $this->data->scroll = array();
        $this->data->footer = array();
        $this->data->onload = array();
        $this->data->control = array();
        $this->data->divs = array();
        return $this->data;
    }

    public function actionViewerror(){
        $this->layout = new \stdClass();
        $this->layout->scroll[] = $this->getComponentText('Controller is missing its methods',array(
            'style' => 'router-error-message',
        ));
        return $this->layout;
    }

    public function setViewData($data){
        $this->data = $data;
    }




}