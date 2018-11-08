<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

/**
 * Trait Fieldlist
 * @package Bootstrap\Components\Elements
 */
trait Fieldlist {

    /**
     * @param $content array with key value pairs or string like this: key1;value1;key2;value2
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'rightswipeid' => 'item-id-rightswipe',  // this is a compound of item id & action of swipe right
     * 'leftswipeid'   => 'item-id-leftswipe', // this is a compound of item id & action of swipe left
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'id' => 'mycustomid',
     * 'swipe_id' => 'swipeareaid' // refers to swipearea in the view
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
     * @return \stdClass
     */
    public function getComponentFormFieldList(string $content, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        if(is_array($content)){
            foreach ($content as $key=>$value){
                if(isset($key) AND isset($value)){
                    $output[] = $key;
                    $output[] = $value;
                }
            }

            if(isset($output)){
                $content = implode(';', $output);
            }
        }

		$obj = new \StdClass;
        $obj->type = 'field-list';
        $obj->content = $content;

        $obj = $this->attachStyles($obj,$styles);
        $obj = $this->attachParameters($obj,$parameters);
        $obj = $this->configureDefaults($obj);

        return $obj;
	}

}