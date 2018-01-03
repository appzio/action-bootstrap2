<?php

namespace Bootstrap\Components;

trait ComponentHelpers {

    /**
     * The model instance. Models are responsible for querying and storing data.
     * They also provide variable, session and validation functionality as well as other useful utility methods.
     *
     * @var \Bootstrap\Models\BootstrapModel $this->model
     */
    public $model;

    /**
     * Users own action (playaction)
     *
     * @var
     */
    public $actionid;

    /**
     * Action id for the config object (action itself)
     */
    public $action_id;

    /**
     * @param $obj
     * @return mixed
     */
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

    /**
     * @param $name
     * @param $params
     * @param bool $default
     * @return bool
     */
    public function addParam($name,$params,$default=false){
        if(isset($params[$name])){
            return $params[$name];
        } else {
            return $default;
        }
    }


    /**
     * Returns the image file name. This method is used in places in which we cannot write the image name.
     * Example usecase is setting the background image of a component
     *
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

	/**
	 * @param $content
	 * @return array
	 */
    public function getParsedContent( $content, $styles = array() ) {

    	$tags = array(
    	    'row' => 'getComponentRow',
	    );

	    $text = str_replace(array("\r\n", "\r"), "\n", $content);
	    $text = trim($text, "\n");
	    $lines = explode("\n", $text);

	    $output = [];

	    $args = array(
		    'width' => 'auto',
		    'color' => ( $styles['color'] ? $styles['color'] : '#676b6f' ),
		    'font-size' => '17',
		    'padding' => '10 15 10 15',
	    );

	    foreach ( $lines as $line ) {
		    foreach ( $tags as $tag => $element ) {
			    if ( preg_match("<$tag>", $line) ) {

			    	// As we use HTML like tags, we could simply put everything through strip_tags
				    $text = strip_tags($line);

				    if ( stristr($text, '**') ) {
				    	$text = str_replace('**', '', $text);
				    	$args['font-weight'] = 'bold';
				    }

					$output[] = $this->{$element}(array(
						$this->getComponentText($text, array(), $args)
					), array(), array(
						'width' => '100%'
					));

					unset($args['font-weight']);

			    } else {
				    $output[] = $this->getComponentText($line, array(), $args);
			    }
		    }
	    }

	    return $output;
    }

}