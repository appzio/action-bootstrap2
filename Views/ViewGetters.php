<?php

namespace Bootstrap\Views;

use function is_numeric;

trait ViewGetters {


    /**
     * @param $field
     * @param $type
     * @param bool $required -- if this is set to true, an empty value will display an erorr on the client
     * @return array|bool|int|\stdClass|string
     */

    public function getData($field, $type, $required=false){

        if(isset($this->data[$field])){

            switch($type){
                case 'array':
                    if(is_array($this->data[$field])){
                        return $this->data[$field];
                    } else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;
                case 'bool':
                    if(is_bool($this->data[$field])){
                        return $this->data[$field];
                    }else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;
                case 'int':
                    if($this->data[$field] == 0) {
                        return 0;
                    }elseif(is_int($this->data[$field])){
                        return $this->data[$field];
                    }else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;
                case 'num':

                    if($this->data[$field] == 0){
                        return 0;
                    }elseif(is_numeric($this->data[$field])){
                        return $this->data[$field];
                    }else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;
                case 'string':
                    if(is_string($this->data[$field])){
                        return $this->data[$field];
                    }else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;
                case 'float':
                    if($this->data[$field] == 0) {
                        return 0;
                    }elseif(is_float($this->data[$field])){
                        return $this->data[$field];
                    }else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;
                case 'object':
                    if(is_object($this->data[$field])){
                        return $this->data[$field];
                    }else {
                        $this->setError('Wrong datatype for GetData '.$field);
                    }
                    break;

                case 'mixed':
                    return $this->data[$field];
                    break;
            }
        }


        switch($type){
            case 'array':
                if($required){
                    $this->setError('Empty data for '.$field);
                }
                return array();
                break;
            case 'bool':
                return false;
                break;
            case 'int':
                return 0;
                break;
            case 'string':
                if($required){
                    $this->setError('Empty data for '.$field);
                }
                return '';
                break;
            case 'float':
                return 0;
                break;
            case 'object':
                if($required){
                    $this->setError('Empty data for '.$field);
                }
                return new \stdClass();
                break;
            case 'mixed':
                return '';
                break;
        }

        $this->setError('Unrecognised data type for '.$field);
        return false;


    }



}