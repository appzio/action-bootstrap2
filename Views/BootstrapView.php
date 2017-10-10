<?php
/**
 * Class BootstrapView
 * @package Bootstrap\Views
 */

namespace Bootstrap\Views;

use Bootstrap\Components\BootstrapComponent;
use Bootstrap\Components\ComponentHelpers;
use Bootstrap\Components\Elements as Elements;

class BootstrapView extends BootstrapComponent implements BootstrapViewInterface   {

    use ViewHelpers;
    use ViewGetters;

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
    public $phpstorm_bugfix;

    /* @var \Bootstrap\Controllers\BootstrapController */
    //public $controller;

    /**
     * The model instance. It is responsible for querying and storing data and
     * also provides useful utility methods for variables, sessions and validation.
     *
     * @var \Bootstrap\Models\BootstrapModel
     */
    public $model;

    /**
     * The main component instance. This class provides access to the other
     * components in the current module.
     *
     * @var \Bootstrap\Components\BootstrapComponent
     */
    public $components;

    /** Includes an array of colors defined for the app / branch / action
     * <code>array ( [text_color] => "#FF000000", [icon_color] => "#FF000000", [background_color] => "#FFCFD8DC", [button_text] => "#FF000000",
    [dark_button_text] => "#FFFFFFFF", [top_bar_text_color] => "#FFFFFFFF", [top_bar_icon_color] => "#FFFFFFFF",
    [button_more_info_color] => "#FF000000", [button_more_info_icon] => "#FFFFFFFF", [button_more_info_icon_color] => "#FFFFFFFF",
    [button_more_info_text_color] => "#FFFFFFFF", [item_text_color] => "#FFFFFFFF", [top_bar_color] => "#FFD32F2F",
    [button_color] => "#FF536DFE", [item_color] => "#FFFFCDD2", [button_icon_color] => "#FFFFFFFF",
    [button_text_color] => "#FFFFFFFF", [side_menu_color] => "#FFFFFFFF", [side_menu_text_color] => "#FF000000" )</code>
     */
    public $colors;

    /**
     * The current menu id if set. Use $this->getMenuId() instead of accessing this property directly.
     *
     * @var
     */
    public $menuid;

    /**
     * Id for the current action as is known only for this particular user.
     *
     * @var
     */
    public $actionid;

    /**
     * Data sent by the controller. Should not be accessed directly, instead use
     * the getData() method.
     *
     * @var \stdClass
     */
    public $data;

    /**
     * This object contains the layout data that will be passed to the client.
     * It should contain 4 arrays named - divs, header, scroll and footer. Each
     * one of those arrays will contain the components that will be rendered in this
     * part of the screen.
     *
     * @var \stdClass
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
     * Id of the bottom app menu
     *
     * @var
     */
    public $bottom_menu_id;

    /**
     * Bottom menu json code is saved here. Normally you shouldn't need to access this directly.
     *
     * @var bool
     */
    public $bottom_menu_json;

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
     * Returns bottom menu. Bottom menu is defined in the web admin.
     *
     * @return array
     */
    public function getBottomMenu()
    {
        return $this->getComponentBottommenu();
    }

    /**
     * All views must define at least tab1() to return any data. Explanation of different sections:
     * Header -- non-scrolling element on top of the view
     * Scroll -- main layout section which scrolls
     * Footer -- non-scrolling element at the bottom of the view
     * Onload -- any actions to be performed when view is activated. This should be fed only with OnClick items
     * Control -- similar to onload, but the command is executed only once after refresh action
     * Divs -- Any divs that are part of the view. Note that divs can be also be defined outside of the tab1, inside a function called divs()
     * @return \stdClass
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