<?php

namespace Bootstrap\Components;

/**
 * Trait ComponentHelpers
 * @package Bootstrap\Components
 */
trait ComponentStyles {

    /**
     * Used by components to attach style parameters. Depending on component, different parameters and styles are supported.
     * This includes documentation for all known parameters and styles, check for individual component for which parameters
     * and styles are supported.
     *
     * Style notations work the same way in the styles.json files. Generally, its recommended to use the styles.json file
     * instead of the inline styles, as the inline styles increase the client payload significantly. styles.json file is loaded
     * by the client only when its been updated, so normally clients would get this styles file upon login and they don't
     * need to fetch it again.
     *
     * @param \stdClass $obj
     * @param array $styles
     * <code>
     * $array = array(
     * 'margin' => '0 0 0 0',
     * 'padding' => '0 0 0 0',
     * 'width' => '200', // or 100%
     * 'height' => '400',
     * 'max_height' => '500',
     * 'background-color' => '#ffffff',
     * 'background-image' => 'filename.png',
     * 'background-size' => 'cover', // or 'contain', 'top' (default)
     * 'crop' => 'round', // or 'yes'
     * 'vertical-align' => 'middle',
     * 'text-align' => 'center',
     * 'font-size' => '14',
     * 'font-ios' => 'Roboto',
     * 'font-weight' => 'Bold',
     * 'font-style' => 'Italic',
     * 'font-android' => 'Roboto',
     * 'color' => '#000000',
     * 'white-space' => 'nowrap',
     * 'children_style' => 'style-class-name' // this is used only in menu, progress and field-list components
     * 'floating' => '1',
     * 'float' => 'right',
     * 'parent_style' => 'style-class-name',
     * 'shadow-color' => '#000000',
     * 'shadow-offset' => '0 1',
     * 'shadow-radius' => '5',
     * 'border-width' => '1',
     * 'border-color' => '#000000',
     * 'border-radius' => '4',
     * 'opacity' => '0.4',
     * );
     * </code>
     *
     * @return \stdClass
     */
	public function attachStyles(\stdClass $obj, array $styles) {

	    if(!$styles){
	        return $obj;
        }

	    $obj->style_content = new \stdClass();

	    foreach($styles as $name=>$style){
            $obj->style_content->$name = $style;
        }

        return $obj;
	}


}