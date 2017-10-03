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



}