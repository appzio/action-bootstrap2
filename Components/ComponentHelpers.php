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
        $height = $this->addParam('imgheight',$params,false);
        $lossless = $this->addParam('lossless',$params,false);
        $format = $this->addParam('format',$params,false);

        if($this->addParam('imgcrop',$params,false)){
            $crop = $this->addParam('imgcrop',$params,false);
        } else {
            $crop = false;
        }

        $params['crop'] = $crop;
        $params['width'] = $width;
        $params['height'] = $height;
        $params['lossless'] = $lossless;
        $params['actionid'] = $this->addParam('actionid',$params,$this->actionid);
        $params['format'] = $format;

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
        
        if ( is_array($content) ) {
            return $this->getNestedContentOutput( $content );
        }

        $tags = $this->getComponentsMap();

        $text = str_replace(array("\r\n", "\r"), "\n", $content);
        $text = trim($text, "\n");
        $lines = explode("\n", $text);

        $output = [];

        $args = array(
            'width' => 'auto',
            'color' => '#676b6f',
            'font-size' => '17',
            'padding' => '10 15 10 15',
        );

        $args = array_merge($args, $styles);

        foreach ( $lines as $i => $line ) {

            if ( $i )
                $args['padding'] = '0 15 10 15';

            if ( stristr($line, '**') ) {
                $line = str_replace('**', '', $line);
                $args['font-weight'] = 'bold';
            }

            $has_tag = false;

            foreach ( $tags as $tag => $element ) {
                if ( strpos($line, $tag) ) {

                    if ( strpos($line, 'richtext') OR strpos($line, 'wraprow') ) {
                        $output[] = $this->getRichTextLayout( $tag, $element, $line, $args );
                    } else {
                        // As we use HTML like tags, we could simply put everything through strip_tags
                        $text = strip_tags($line);

                        $output[] = $this->{$element}(array(
                            $this->getComponentText($text, array(), $args)
                        ), array(), array(
                            'width' => '100%'
                        ));
                    }

                    $has_tag = true;
                    break;
                }

            }

            // No tags - simply output a some text
            if ( !$has_tag ) {
                $output[] = $this->getComponentText($line, array(), $args);
            }

            unset($args['font-weight']);
        }

        return $output;
    }

    public function getRichTextLayout( $tag, $element, $input, $args ) {

    	$data = array();

    	// Remove the wrapping element
	    $input = preg_replace("~<$tag>(.*?)<\/$tag>~", '$1', $input);

	    $nodes = $this->extractTags( $input, 'text' );

	    foreach($nodes as $node){
	    	$params = $this->getNodeParams( $node );
	    	$styles = $this->getNodeStyles( $node );
	    	$data[] = $this->getComponentText($node['contents'], $params, $styles);
	    }

	    return $output[] = $this->{$element}($data, array(), $args);
    }

    public function getNodeParams( $node ) {

	    if ( !isset($node['attributes']['link']) ) {
		    return array();
	    }

	    $link = $node['attributes']['link'];

	    if ( preg_match('~action~', $link) ) {
	    	$action_path = str_replace('action:', '', $link);
	    	return array(
	    		'onclick' => $this->getOnclickOpenAction( $action_path )
		    );
	    }

	    return array(
		    'onclick' => $this->getOnclickOpenUrl( $link )
	    );
    }

    public function getNodeStyles( $node ) {

    	if ( !isset($node['attributes']['style']) ) {
    		return array();
	    }

	    $output = array();

	    $styles = @explode(';', $node['attributes']['style']);

	    foreach ( $styles as $style ) {
		    $style_params = explode(':', $style);

		    if ( !isset($style_params[1]) ) {
		    	continue;
		    }

		    $output[trim($style_params[0])] = trim($style_params[1]);
    	}

    	return $output;
    }

	/**
	 * extractTags()
	 * Extract specific HTML tags and their attributes from a string.
	 *
	 * You can either specify one tag, an array of tag names, or a regular expression that matches the tag name(s).
	 * If multiple tags are specified you must also set the $selfclosing parameter and it must be the same for
	 * all specified tags (so you can't extract both normal and self-closing tags in one go).
	 *
	 * The function returns a numerically indexed array of extracted tags. Each entry is an associative array
	 * with these keys :
	 *  tag_name    - the name of the extracted tag, e.g. "a" or "img".
	 *  offset      - the numberic offset of the first character of the tag within the HTML source.
	 *  contents    - the inner HTML of the tag. This is always empty for self-closing tags.
	 *  attributes  - a name -> value array of the tag's attributes, or an empty array if the tag has none.
	 *  full_tag    - the entire matched tag, e.g. '<a href="http://example.com">example.com</a>'. This key
	 *                will only be present if you set $return_the_entire_tag to true.
	 *
	 * @param string $html The HTML code to search for tags.
	 * @param string|array $tag The tag(s) to extract.
	 * @param bool $selfclosing Whether the tag is self-closing or not. Setting it to null will force the script to try and make an educated guess.
	 * @param bool $return_the_entire_tag Return the entire matched tag in 'full_tag' key of the results array.
	 * @param string $charset The character set of the HTML code. Defaults to ISO-8859-1.
	 *
	 * @return array An array of extracted tags, or an empty array if no matching tags were found.
	 */
	public function extractTags( $html, $tag, $selfclosing = null, $return_the_entire_tag = false, $charset = 'ISO-8859-1' ){

		if ( is_array($tag) ){
			$tag = implode('|', $tag);
		}

		//If the user didn't specify if $tag is a self-closing tag we try to auto-detect it
		//by checking against a list of known self-closing tags.
		$selfclosing_tags = array( 'area', 'base', 'basefont', 'br', 'hr', 'input', 'img', 'link', 'meta', 'col', 'param' );
		if ( is_null($selfclosing) ){
			$selfclosing = in_array( $tag, $selfclosing_tags );
		}

		//The regexp is different for normal and self-closing tags because I can't figure out
		//how to make a sufficiently robust unified one.
		if ( $selfclosing ){
			$tag_pattern =
				'@<(?P<tag>'.$tag.')           # <tag
            (?P<attributes>\s[^>]+)?       # attributes, if any
            \s*/?>                   # /> or just >, being lenient here 
            @xsi';
		} else {
			$tag_pattern =
				'@<(?P<tag>'.$tag.')           # <tag
            (?P<attributes>\s[^>]+)?       # attributes, if any
            \s*>                 # >
            (?P<contents>.*?)         # tag contents
            </(?P=tag)>               # the closing </tag>
            @xsi';
		}

		$attribute_pattern =
			'@
        (?P<name>\w+)                         # attribute name
        \s*=\s*
        (
            (?P<quote>[\"\'])(?P<value_quoted>.*?)(?P=quote)    # a quoted value
            |                           # or
            (?P<value_unquoted>[^\s"\']+?)(?:\s+|$)           # an unquoted value (terminated by whitespace or EOF) 
        )
        @xsi';

		//Find all tags
		if ( !preg_match_all($tag_pattern, $html, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE ) ){
			//Return an empty array if we didn't find anything
			return array();
		}

		$tags = array();
		foreach ($matches as $match){

			//Parse tag attributes, if any
			$attributes = array();
			if ( !empty($match['attributes'][0]) ){

				if ( preg_match_all( $attribute_pattern, $match['attributes'][0], $attribute_data, PREG_SET_ORDER ) ){
					//Turn the attribute data into a name->value array
					foreach($attribute_data as $attr){
						if( !empty($attr['value_quoted']) ){
							$value = $attr['value_quoted'];
						} else if( !empty($attr['value_unquoted']) ){
							$value = $attr['value_unquoted'];
						} else {
							$value = '';
						}

						//Passing the value through html_entity_decode is handy when you want
						//to extract link URLs or something like that. You might want to remove
						//or modify this call if it doesn't fit your situation.
						$value = html_entity_decode( $value, ENT_QUOTES, $charset );

						$attributes[$attr['name']] = $value;
					}
				}

			}

			$tag = array(
				'tag_name' => $match['tag'][0],
				'offset' => $match[0][1],
				'contents' => !empty($match['contents'])?$match['contents'][0]:'', //empty for self-closing tags
				'attributes' => $attributes,
			);
			if ( $return_the_entire_tag ){
				$tag['full_tag'] = $match[0][0];
			}

			$tags[] = $tag;
		}

		return $tags;
	}

	public function getComponentsMap() {
	    return [
            'row' => 'getComponentRow',
            'column' => 'getComponentColumn',
            'richtext' => 'getComponentRichText',
            'wraprow' => 'getComponentWrapRow',
        ];
    }

	public function getNestedContentOutput( $content ) {

        $data = [];

        foreach ($content as $entry) {

            if ( $entry['type'] != 'text' OR !isset($entry['content']) ) {
                continue;
            }


            $params = $this->getEntryParams( $entry );
            $styles = ( isset($entry['styles']) ? $entry['styles'] : [] );

            $data[] = $this->getComponentText($entry['content'], $params, $styles);
        }

        return $data;
    }

    public function getEntryParams( $entry ) {

	    if ( !isset($entry['params']) OR empty($entry['params']) ) {
	        return [];
        }

	    $output = [];

        foreach ($entry['params'] as $key => $param) {

            if ( $key == 'link' ) {
                if ( preg_match('~action~', $param) ) {
                    $action_path = str_replace('action:', '', $param);
                    $output['onclick'] = $this->getOnclickOpenAction($action_path, false, [
                        'back_button' => 1
                    ]);
                } else {
                    $output['onclick'] = $this->getOnclickOpenUrl( $param );
                }
            }

	    }

	    return $output;
    }

}