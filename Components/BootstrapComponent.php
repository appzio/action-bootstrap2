<?php

namespace Bootstrap\Components;

use function array_merge;
use Bootstrap\Components\BootstrapComponentInterface;
use Bootstrap\Components\Elements as Elements;
use Bootstrap\Models\BootstrapModel;
use Bootstrap\Views\ViewGetters;
use Bootstrap\Views\ViewHelpers;

class BootstrapComponent implements BootstrapComponentInterface {

    /* this is here just to fix a phpstorm auto complete bug with namespaces */

    /* @var \Bootstrap\Components\Elements\Divider */
    public $phpstorm_bugfix;

    /* @var \Bootstrap\Models\BootstrapModel */
    public $model;

    public $errors;

    public $imagesobj;
    public $varcontent;
    public $configobj;
    public $branchobj;

    /* @var \Bootstrap\Router\BootstrapRouter */
    public $router;

    public $current_route;

    /*  you can feed divs to be automatically included here*/
    private $divs = array();

    public $aspect_ratio;
    public $screen_width;
    public $screen_height;

    public $colors;

    /* this is the data passed from the controller */
    public $data;

    public $color_text_color;
    public $color_icon_color;
    public $color_background_color;
    public $color_dark_button_text;
    public $color_top_bar_text_color;
    public $color_top_bar_icon_color;
    public $color_button_more_info_color;
    public $color_button_more_info_icon_color;
    public $color_item_text_color;
    public $color_top_bar_color;
    public $color_button_color;
    public $color_item_color;
    public $color_button_text_color;
    public $color_side_menu_color;
    public $color_side_menu_text_color;
    public $color_topbar_hilite;

    use ComponentHelpers;

    /* all component traits need to be defined here */
    use Elements\Banner;
    use Elements\Column;
    use Elements\FormFieldPassword;
    use Elements\FormFieldText;
    use Elements\FormFieldTextArea;
    use Elements\FormFieldUploadImage;
    use Elements\FormFieldUploadVideo;

    use Elements\Html;
    use Elements\Image;
    use Elements\InfiniteScroll;
    use Elements\Loader;
    use Elements\Onclick;

    use Elements\Progress;
    use Elements\RangeSlider;
    use Elements\Row;
    use Elements\Text;
    use Elements\Video;
    use Elements\Fieldlist;

    use Elements\FullpageLoader;
    use Elements\Spacers;

    use Elements\Map;
    use Elements\Calendar;

    use Elements\Divider;
    use Elements\Swipe;
    use Elements\SwipeNavi;

    use Elements\FormFieldList;
    use Elements\FormFieldBirthday;
    use Elements\Bottommenu;
    use Elements\FormFieldOnoff;
    use Elements\Div;
    use Elements\ConfirmationDialog;
    use Elements\SwipeAreaNavigation;

    use ViewGetters;
    use ViewHelpers;


    public function __construct($obj){
        /* this exist to make the referencing of
        passed objects & variables easier */

        while($n = each($this)){
            $key = $n['key'];
            if(isset($obj->$key) AND !$this->$key){
                $this->$key = $obj->$key;
            }
        }

        /* set colors */
        foreach($this->colors as $name=>$color){
            $name = 'color_'.$name;

            if(property_exists($this,$name)){
                $this->$name = $color;
            }
        }

    }

    public function getErrors(){
        return $this->errors;
    }


    public function addDivs(array $divs){
        if(!empty($this->divs)){
            $this->divs = array_merge($this->divs,$divs);
        } else {
            $this->divs = $divs;
        }
    }

    public function getDivs(){
        return $this->divs;
    }



}