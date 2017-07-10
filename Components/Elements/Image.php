<?php

namespace Bootstrap\Components\Elements;
use Bootstrap\Views\BootstrapView;

trait Image {


    /**
     * selected_state, variable, onclick, style, image_fallback (when clicked, change to this image), selected_state,
     * lazy (loads after view), tap_to_open, tap_image (image file name)
     *
     * @param $content string, no support for line feeds
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'variable' => 'variable_name',
     * 'variable'   => 'variablename',
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'style' => 'style-class-name',
     * );
     * </code>
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
     * @return \stdClass
     */

    /**
     * @param $content string, filename or url
     * @param array $styles 'margin', 'padding', 'orientation', 'background', 'alignment', 'radius', 'opacity',
     * 'orientation', 'height', 'width', 'align', 'crop', 'text-style', 'font-size', 'text-color', 'border-color',
     * 'border-width', 'font-android', 'font-ios', 'background-color', 'background-image', 'background-size',
     * 'color', 'shadow-color', 'shadow-offset', 'shadow-radius', 'vertical-align', 'border-radius', 'text-align',
     * 'lazy', 'floating' (1), 'float' (right | left), 'max-height', 'white-space' (no-wrap), parent_style
     * @param array $parameters selected_state, variable, onclick, style, image_fallback (when clicked, change to this image), selected_state,
     * lazy (loads after view), tap_to_open, tap_image (image file name)
     * @return \stdClass
     */

    public function getComponentImage(string $filename, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */


        if(isset($parameters['use_filename']) AND $parameters['use_filename'] == 1){
            $file = $filename;
        } else {
            $file = false;
            $file = $this->getImageFileName($filename,$parameters);
        }

        // Check if $filename is an external URL
        if ( empty($file) ) {
            if (filter_var($filename, FILTER_VALIDATE_URL) !== false) {
                $file = $filename;
            }
        }

        if($file){
            $obj = new \StdClass;
            $obj->type = 'image';
            $obj->content = $file;

            $obj = $this->attachStyles($obj,$styles);
            $obj = $this->attachParameters($obj,$parameters);
            $obj = $this->configureDefaults($obj);

            return $obj;
        } else {
            return $this->getComponentText('Image not found '.$filename);
            //$this->setError('Image not found '.$filename);
        }

    }



}


