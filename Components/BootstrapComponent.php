<?php

namespace Bootstrap\Components;

use Bootstrap\Components\BootstrapComponentInterface;
use Bootstrap\Components\ClientComponents as ClientComponents;
use Bootstrap\Components\Snippets as Snippets;
use Bootstrap\Components\AppzioUiKit as AppzioUiKit;

use Bootstrap\Models\BootstrapModel;
use Bootstrap\Views\ViewGetters;
use Bootstrap\Views\ViewHelpers;
use ImagesController;
use packages\actionMitems\Components\uiKitAccordion;

/**
 * Class BootstrapComponent
 * @package Bootstrap\Components
 */
class BootstrapComponent implements BootstrapComponentInterface {

    /* this is here just to fix a phpstorm auto complete bug with namespaces */

    /* @var \Bootstrap\Components\ClientComponents\Divider */
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

    /**
     * use depreceated
     */
    public $color_text_color;
    /**
     * use depreceated
     */
    public $color_icon_color;
    /**
     * use depreceated
     */
    public $color_background_color;
    /**
     * use depreceated
     */
    public $color_top_bar_text_color;
    /**
     * use depreceated
     */
    public $color_button_more_info_color;
    /**
     * use depreceated
     */
    public $color_button_more_info_icon_color;
    /**
     * use depreceated
     */
    public $color_item_text_color;
    /**
     * use depreceated
     */
    public $color_top_bar_color;
    /**
     * use depreceated
     */
    public $color_button_color;
    /**
     * use depreceated
     */
    public $color_item_color;
    /**
     * use depreceated
     */
    public $color_button_text_color;
    /**
     * use depreceated
     */
    public $color_side_menu_color;
    /**
     * use depreceated
     */
    public $color_side_menu_text_color;
    /**
     * use depreceated
     */
    public $color_topbar_hilite;

    use ComponentHelpers;
    use ComponentParameters;
    use ComponentStyles;
    use CalendarHelper;

    /* all component traits need to be defined here */
    use ClientComponents\Banner;
    use ClientComponents\Column;
    use ClientComponents\FormFieldPassword;
    use ClientComponents\FormFieldText;
    use ClientComponents\FormFieldTextArea;
    use ClientComponents\FormFieldUploadImage;
    use ClientComponents\FormFieldUploadVideo;

    use ClientComponents\Html;
    use ClientComponents\Image;
    use ClientComponents\InfiniteScroll;
    use ClientComponents\Loader;
    use ClientComponents\Onclick;

    use ClientComponents\Progress;
    use ClientComponents\RangeSlider;
    use ClientComponents\Row;
    use ClientComponents\WrapRow;
    use ClientComponents\Text;
    use ClientComponents\RichText;
    use ClientComponents\Video;
    use ClientComponents\Fieldlist;

    use ClientComponents\FullpageLoader;
    use ClientComponents\Spacers;

    use ClientComponents\Map;
    use ClientComponents\Calendar;

    use ClientComponents\Divider;
    use ClientComponents\Swipe;
    use ClientComponents\SwipeNavi;

    use ClientComponents\FormFieldList;
    use ClientComponents\FormFieldBirthday;
    use ClientComponents\Bottommenu;
    use ClientComponents\FormFieldOnoff;
    use ClientComponents\Div;
    use ClientComponents\ConfirmationDialog;
    use ClientComponents\SwipeAreaNavigation;
    use ClientComponents\Timer;
    use ClientComponents\SwipeStack;
    use ClientComponents\ImageGrid;
    use ClientComponents\Charts;

    use Snippets\Forms\formHintedField;

    use AppzioUiKit\Controls\uiKitLikeStar;
    use AppzioUiKit\Controls\uiKitDoubleSelector;
    use AppzioUiKit\Controls\uiKitHintedCalendar;
    use AppzioUiKit\Controls\uiKitHintedTime;
    use AppzioUiKit\Controls\uiKitHierarchicalCategories;

    use AppzioUiKit\Text\uiKitTextHeader;
    use AppzioUiKit\Text\uiKitTextBlock;

    use AppzioUiKit\Headers\uiKitTitlePriceLocation;
    use AppzioUiKit\Headers\uiKitHeaderWithImage;
    use AppzioUiKit\Headers\uiKitHeaderBlock;
    use AppzioUiKit\Headers\uiKitTwoColumnHeader;
    use AppzioUiKit\Headers\uiKitDefaultHeader;
    use AppzioUiKit\Headers\uiKitAuthHeader;
    use AppzioUiKit\Headers\uiKitBackgroundHeader;

    use AppzioUiKit\Buttons\uiKitButtonFilled;
    use AppzioUiKit\Buttons\uiKitButtonHollow;
    use AppzioUiKit\Buttons\uiKitDoubleButtons;
    use AppzioUiKit\Buttons\uiKitButtonBlock;
    use AppzioUiKit\Buttons\uiKitButtonHollowWithIcon;

    use AppzioUiKit\Forms\uiKitDivider;
    use AppzioUiKit\Forms\uiKitImageGridUpload;
    use AppzioUiKit\Forms\uiKitSearchField;
    use AppzioUiKit\Forms\uiKitHintedTextField;
    use AppzioUiKit\Forms\uiKitTagRadioButtons;
    use AppzioUiKit\Forms\uiKitHintedSelectButtonField;
    use AppzioUiKit\Forms\uiKitSlider;
    use AppzioUiKit\Forms\uiKitTwoHandSlider;
    use AppzioUiKit\Forms\uiKitFormSectionHeader;
    use AppzioUiKit\Forms\uiKitGeneralField;

    use AppzioUiKit\Listing\uiKitTagList;
    use AppzioUiKit\Listing\uiKitThreeColumnImageSwiper;
    use AppzioUiKit\Listing\uiKitFullWidthImageSwiper;
    use AppzioUiKit\Listing\uiKitItemListInfinite;
	use AppzioUiKit\Listing\uiKitNewsListInfinite;
	use AppzioUiKit\Listing\uiKitItemListPlain;
	use AppzioUiKit\Listing\uiKitListItem;
	use AppzioUiKit\Listing\uiKitSearchItem;

    use AppzioUiKit\Divs\uiKitBlockButtonsDiv;
    use AppzioUiKit\Divs\uiKitReportItemDiv;
    use AppzioUiKit\Divs\uiKitRemoveItemDiv;
    use AppzioUiKit\Divs\uiKitPurchaseDiv;
    use AppzioUiKit\Divs\uiKitVideoDiv;

    use AppzioUiKit\Fullviews\uiKitIntroWithButtons;

	// Articles
	use AppzioUiKit\Articles\uiKitArticleItem;
	use AppzioUiKit\Articles\uiKitArticleCategoryItem;
	use AppzioUiKit\Articles\uiKitArticleHeading;
	use AppzioUiKit\Articles\uiKitArticleText;
	use AppzioUiKit\Articles\uiKitArticleQABlock;
	use AppzioUiKit\Articles\uiKitArticleImage;
	use AppzioUiKit\Articles\uiKitArticleVideo;
	use AppzioUiKit\Articles\uiKitArticleBlockquote;
	use AppzioUiKit\Articles\uiKitArticleNote;
	use AppzioUiKit\Articles\uiKitArticleGallery;
	use AppzioUiKit\Articles\uiKitArticleNextentry;

	use AppzioUiKit\Text\uiKitInformationTile;
	use AppzioUiKit\Listing\uiKitIconList;
	use AppzioUiKit\Listing\uiKitPeopleList;
	use AppzioUiKit\Listing\uiKitList;
	use AppzioUiKit\Listing\uiKitAccordion;
	use AppzioUiKit\Buttons\uiKitIconButton;
	use AppzioUiKit\Buttons\uiKitWideButton;
	use AppzioUiKit\Text\uiKitSectionLabel;
	use AppzioUiKit\Divs\uiKitEmailDiv;
	use AppzioUiKit\Divs\uiKitEmailWithInputDiv;
	use AppzioUiKit\Divs\uiKitGeneralListDiv;

	use AppzioUiKit\Navigation\uiKitTabNavigation;
	use AppzioUiKit\Navigation\uiKitTopbar;
	use AppzioUiKit\Navigation\uiKitMenuItem;
	use AppzioUiKit\Navigation\uiKitMenuProfilebox;
	use AppzioUiKit\Navigation\uiKitFloatingButtons;

	use AppzioUiKit\Divs\uiKitDivHeader;
	use AppzioUiKit\Forms\uiKitTimeInput;

	use AppzioUiKit\Buttons\uiKitSwipeDeleteButton;
	use AppzioUiKit\Buttons\uiKitSwipeUpdateButton;

	use AppzioUiKit\Swiper\uiKitUserSwiper;

	use AppzioUiKit\Timer\uiKitTimer;

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
        if(isset($this->colors)){
            foreach($this->colors as $name=>$color){
                $name = 'color_'.$name;

                if(property_exists($this,$name)){
                    $this->$name = $color;
                }
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
     * Return divs object
     *
     * @return array
     */
    public function getDivs(){
        return $this->divs;
    }

}