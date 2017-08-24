<?php

namespace Bootstrap\Components;

use function array_search;
use function is_numeric;
use function is_string;

trait ComponentHelpers {

    /** @var \Bootstrap\Models\BootstrapModel $this->model */
    public $model;

    /* users own action (playaction) */
    public $actionid;

    /* action id for the config object (action itself) */
    public $action_id;

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


    public function attachParameters(\stdClass $obj, array $parameters, array $allowed=array(),array $required = array()) {

	    if(!$parameters){
	        if($required){
                return $this->getComponentText('Missing required parameter for '.$obj->type);
            }
            return $obj;
        }

        foreach($parameters as $name=>$param){
	        if($allowed){
                if(array_search($name, $allowed)){
                    $obj->$name = $param;
                } else {
                    return $this->getComponentText('Disallowed parameter '.$name);
                }
            } else {
                $obj->$name = $param;
            }
        }

        /* outputs an error if a required parameter is missing */
        if(!empty($required)){

            foreach ($required as $item){
                if(!array_search($item, $parameters)){
                    return $this->getComponentText('Missing required parameter '.$item);
                }
            }
        }

        /* client understands id's rather than names, so it gets converted to id here */
        if(isset($obj->variable) AND is_string($obj->variable) AND !is_numeric($obj->variable)){
            if($this->model->getVariableId($obj->variable)){
                $obj->variable = $this->model->getVariableId($obj->variable);
            }
        }

        return $obj;
    }


    public function configureDefaults($obj){

	    if(!isset($obj->style) AND !isset($obj->style_content)){
	        $obj->style = 'element-' .$obj->type .'-default';
        } elseif(isset($obj->style_content) AND empty($obj->style_content)){
            $obj->style = 'element-' .$obj->type .'-default';
        } elseif(isset($obj->style) AND empty($obj->style)){
            $obj->style = 'element-' .$obj->type .'-default';
        }

        return $obj;

    }

    public function addParam($name,$params,$default=false){
        if(isset($params[$name])){
            return $params[$name];
        } else {
            return $default;
        }
    }


    /**
     * @param $image
     * @param array $params isvar, width, height, crop, defaultimage, debug
     * @return bool
     */

    public function getImageFileName($image,$params=array()){

        $isvar = $this->addParam('isvar',$params,false);  // you can use variable id
        $actionimage = $this->addParam('actionimage',$params,false); // you can use action field name portrait_image for example

        $defaultimage = $this->addParam('defaultimage',$params,false);
        $debug = $this->addParam('debug',$params,false);
        $width = $this->addParam('imgwidth',$params,640);
        $height = $this->addParam('imgheight',$params,640);

        if($this->addParam('imgcrop',$params,false)){
            $crop = $this->addParam('imgcrop',$params,false);
        } else {
            $crop = false;
        }

        $params['crop'] = $crop;
        $params['width'] = $width;
        $params['height'] = $height;
        $params['actionid'] = $this->addParam('actionid',$params,$this->actionid);

        if(isset($this->branchobj->id)){
            $params['branchid'] = $this->branchobj->id;
        }

        if(isset($this->branchobj->asset_loading) AND $this->branchobj->asset_loading AND !isset($params['priority'])){
            switch($this->branchobj->asset_loading){
                case 'default':
                    break;

                case 'before_start':
                    $params['priority'] = 1;
                    break;

                case 'nopreloading':
                    $params['priority'] = 3;
                    break;

                case 'notinassetlist':
                    $params['not_to_assetlist'] = true;
                    break;

            }
        }

        if ( empty($image) ) {
            return $this->imagesobj->getAsset($defaultimage,$params);
        }

        if ($isvar === true) {
            if($this->model->getSavedVariable($image)){
                $basename = basename($this->model->getSavedVariable($image));
                // we need to rewrite the params not to include "isvar"
                return $this->getImageFileName($basename,array('imgwidth'=>$width,'imgheight'=>$height,'imgcrop'=>$crop,'debug' => $debug));
            } else {
                return $defaultimage;
            }
        } elseif($actionimage) {
            if(isset($this->configobj->$image)){
                $basename = basename($this->configobj->$image);

                return $this->getImageFileName($basename,array('imgwidth'=>$width,'imgheight'=>$height,'imgcrop'=>$crop,'debug' => $debug));
            } else {
                return $defaultimage;
            }
        } elseif(is_string($image)) {
            $file = $this->imagesobj->getAsset($image,$params);
        } else {
            return false;
        }

        if($file){
            return $file;
        } else {
            return $this->imagesobj->getAsset($defaultimage,$params);
        }

    }


}