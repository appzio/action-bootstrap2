<?php

namespace Bootstrap\Components;

/**
 * Trait ComponentHelpers
 * @package Bootstrap\Components
 */
trait ComponentParameters {

    /**
     * This is a helper for attaching component parameters and placeholder for parameter related documentation.
     *
     * @param \stdClass $obj
     * @param array $parameters
     * @param array $allowed
     * @param array $required
     * @return \stdClass
     */
    public function attachParameters(\stdClass $obj, array $parameters, array $allowed=array(),array $required = array()) {


        if(!$parameters){
            if($required){
                return $this->getComponentText('Missing required parameter for '.$obj->type);
            }
            return $obj;
        }

        foreach($parameters as $name=>$param){
            if($allowed){
                if(in_array($name,$allowed)){
                    $obj->$name = $param;
                } elseif(in_array($name,$required)) {
                    $obj->$name = $param;
                } else {
                    return $this->getComponentText('Disallowed parameter '.$name);
                }
            } else {
                $obj->$name = $param;
            }
        }

        if(isset($obj->imgwidth)){
            unset($obj->imgwidth);
        }

        if(isset($obj->imgheight)){
            unset($obj->imgheight);
        }


        /* outputs an error if a required parameter is missing */
        if(!empty($required)){

            foreach ($required as $item){
                if(!isset($obj->$item)){
                    return $this->getComponentText('Missing required parameter '.$item);
                }
            }
        }

        /* client understands id's rather than names, so it gets converted to id here */
        if($this->model){
            if(isset($obj->variable) AND is_string($obj->variable) AND !is_numeric($obj->variable)){
                if($this->model->getVariableId($obj->variable)){
                    $obj->variable = $this->model->getVariableId($obj->variable);
                }
            }

            if(isset($obj->variable2) AND is_string($obj->variable2) AND !is_numeric($obj->variable2)){
                if($this->model->getVariableId($obj->variable2)){
                    $obj->variable2 = $this->model->getVariableId($obj->variable2);
                }
            }
        }

        return $obj;
    }



}