<?php

namespace Bootstrap\Components;

use function array_merge;
use Bootstrap\Components\BootstrapComponentInterface;
use Bootstrap\Components\Elements as Elements;

class BootstrapComponent implements BootstrapComponentInterface {

    /* this is here just to fix a phpstorm auto complete bug with namespaces */
    /* @var \Bootstrap\Models\BootstrapModel */
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


    public function __construct($obj){
        /* this exist to make the referencing of
        passed objects & variables easier */

        while($n = each($this)){
            $key = $n['key'];
            if(isset($obj->$key) AND !$this->$key){
                $this->$key = $obj->$key;
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