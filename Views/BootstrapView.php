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

/**
 * Class BootstrapView
 * @package Bootstrap\Views
 */
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

    /**
     * @var
     */
    public $colors;

    /**
     * @var
     */
    public $menuid;
    /**
     * @var
     */
    public $actionid;

    /* data sent by the controller */
    /**
     * @var stdClass
     */
    public $data;

    /* layout code */
    /**
     * @var
     */
    public $layout;

    /**
     * @var
     */
    public $color_text_color;
    /**
     * @var
     */
    public $color_icon_color;
    /**
     * @var
     */
    public $color_background_color;
    /**
     * @var
     */
    public $color_button_text;
    /**
     * @var
     */
    public $color_dark_button_text;
    /**
     * @var
     */
    public $color_top_bar_text_color;
    /**
     * @var
     */
    public $color_top_bar_icon_color;
    /**
     * @var
     */
    public $color_button_more_info_color;
    /**
     * @var
     */
    public $color_button_more_info_icon_color;
    /**
     * @var
     */
    public $color_button_more_info_text_color;
    /**
     * @var
     */
    public $color_item_text_color;
    /**
     * @var
     */
    public $color_top_bar_color;
    /**
     * @var
     */
    public $color_button_color;
    /**
     * @var
     */
    public $color_item_color;
    /**
     * @var
     */
    public $color_button_icon_color;
    /**
     * @var
     */
    public $color_button_text_color;
    /**
     * @var
     */
    public $color_side_menu_color;
    /**
     * @var
     */
    public $color_side_menu_text_color;
    /**
     * @var
     */
    public $color_topbar_hilite;

    /**
     * @var
     */
    public $bottom_menu_id;
    /**
     * @var bool
     */
    public $bottom_menu_json;

    /*Array ( [text_color] => #FF000000 [icon_color] => #FF000000 [background_color] => #FFCFD8DC [button_text] => #FF000000
    [dark_button_text] => #FFFFFFFF [top_bar_text_color] => #FFFFFFFF [top_bar_icon_color] => #FFFFFFFF
    [button_more_info_color] => #FF000000 [button_more_info_icon] => #FFFFFFFF [button_more_info_icon_color] => #FFFFFFFF
    [button_more_info_text_color] => #FFFFFFFF [item_text_color] => #FFFFFFFF [top_bar_color] => #FFD32F2F
    [button_color] => #FF536DFE [item_color] => #FFFFCDD2 [button_icon_color] => #FFFFFFFF
     [button_text_color] => #FFFFFFFF [side_menu_color] => #FFFFFFFF [side_menu_text_color] => #FF000000 )*/

    /**
     * BootstrapView constructor.
     * @param $obj
     */
    public function __construct($obj){
        
        foreach ($this as $key => $value ) {
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

        if($this->bottom_menu_id){
            $this->bottom_menu_json = true;
        }

    }

    /**
     * @return array
     */
    public function getBottomMenu()
    {
        return $this->getComponentBottommenu();
    }

    /**
     * @return stdClass
     */
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

    /**
     * @param $data
     */
    public function setViewData($data){
        $this->data = $data;
    }

}