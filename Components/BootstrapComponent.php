<?php

namespace Bootstrap\Components;

use function array_merge;
use Bootstrap\Components\BootstrapComponentInterface;
use Bootstrap\Components\Elements as Elements;
use Bootstrap\Models\BootstrapModel;
use Bootstrap\Views\ViewGetters;
use Bootstrap\Views\ViewHelpers;

/**
 * Class BootstrapComponent
 * @package Bootstrap\Components
 */
class BootstrapComponent implements BootstrapComponentInterface {

    /* this is here just to fix a phpstorm auto complete bug with namespaces */

    /* @var \Bootstrap\Components\Elements\Divider */
    public $phpstorm_bugfix;

    /* @var \Bootstrap\Models\BootstrapModel */
    public $model;

    /**
     * @var
     */
    public $errors;

    /**
     * @var
     */
    public $imagesobj;

    /**
     * @var
     */
    public $varcontent;

    /**
     * @var
     */
    public $configobj;

    /**
     * @var
     */
    public $branchobj;

    /* @var \Bootstrap\Router\BootstrapRouter */
    public $router;

    /**
     * @var
     */
    public $current_route;

    /**
     * You can feed divs to be automatically included here
     * @var array
     */
    private $divs = array();

    /**
     * @var
     */
    public $aspect_ratio;

    /**
     * @var
     */
    public $screen_width;

    /**
     * @var
     */
    public $screen_height;

    /**
     * @var
     */
    public $colors;

    /**
     * This is the data passed from the controller
     * @var
     */
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
    use Elements\Timer;

    use ViewGetters;
    use ViewHelpers;

    /**
     * BootstrapComponent constructor.
     * @param $obj
     */
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

    /**
     * @return mixed
     */
    public function getErrors(){
        return $this->errors;
    }

    /**
     * @param array $divs
     */
    public function addDivs(array $divs){
        if(!empty($this->divs)){
            $this->divs = array_merge($this->divs,$divs);
        } else {
            $this->divs = $divs;
        }
    }

    /**
     * @return array
     */
    public function getDivs(){
        return $this->divs;
    }

}