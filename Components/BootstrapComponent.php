<?php

namespace Bootstrap\Components;

use function array_merge;
use Bootstrap\Components\BootstrapComponentInterface;
use Bootstrap\Components\Elements as Elements;
use Bootstrap\Models\BootstrapModel;
use Bootstrap\Views\ViewGetters;
use Bootstrap\Views\ViewHelpers;
use ImagesController;

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
     * Image processor object.
     * @var ImagesController
     */
    public $imagesobj;

    /**
     * Includes currently loaded user variables in array. Normally you would use $this->getSavedVariable instead of accessing this directly.
     * Declared public for easier debugging for certain cases.
     * @var
     */
    public $varcontent;

    /**
     * Actions configuration as defined in the web admin. All these can be overriden using $this->rewriteActionConfigField()
     * @var
     */
    public $configobj;

    /**
     * Configuration array for the branch. Includes all configuration fields defined in the web admin.
     * @var
     */
    public $branchobj;

    /* @var \Bootstrap\Router\BootstrapRouter */
    public $router;

    /**
     * Holds the currently active route information /Controllername/Methodname/menuid
     * @var
     */
    public $current_route;

    /**
     * You can feed divs to be automatically included here
     * @var array
     */
    private $divs = array();

    /**
     * aspect ration is screen_width / screen_height
     * @var
     */
    public $aspect_ratio;

    /**
     * screen width in pixels
     * @var
     */
    public $screen_width;

    /**
     * screen height in pixels
     * @var
     */
    public $screen_height;

    /**
     * Includes an array of colors defined for the app / branch / action
     * @var
     */
    public $colors;

    /**
     * This is the data passed from the controller
     * @var
     */
    public $data;

    /* use depreceated */
    public $color_text_color;
    /* use depreceated */
    public $color_icon_color;
    /* use depreceated */
    public $color_background_color;
    /* use depreceated */
    public $color_dark_button_text;
    /* use depreceated */
    public $color_top_bar_text_color;
    /* use depreceated */
    public $color_top_bar_icon_color;
    /* use depreceated */
    public $color_button_more_info_color;
    /* use depreceated */
    public $color_button_more_info_icon_color;
    /* use depreceated */
    public $color_item_text_color;
    /* use depreceated */
    public $color_top_bar_color;
    /* use depreceated */
    public $color_button_color;
    /* use depreceated */
    public $color_item_color;
    /* use depreceated */
    public $color_button_text_color;
    /* use depreceated */
    public $color_side_menu_color;
    /* use depreceated */
    public $color_side_menu_text_color;
    /* use depreceated */
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
     * Register div's to be used with this function. Takes an array with divid which points to component name (without file extension)
     *
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