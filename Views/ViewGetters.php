<?php

namespace Bootstrap\Views;

trait ViewGetters {

    public function getData($field,$type){

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
                    if(is_int($this->data[$field])){
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
                    if(is_float($this->data[$field])){
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
            }
        }

        switch($type){
            case 'array':
                $this->setError('Empty data for '.$field);
                return array();
                break;
            case 'bool':
                $this->setError('Empty data for '.$field);
                return false;
                break;
            case 'int':
                $this->setError('Empty data for '.$field);
                return 0;
                break;
            case 'string':
                $this->setError('Empty data for '.$field);
                return '';
                break;
            case 'float':
                $this->setError('Empty data for '.$field);
                return 0;
                break;
            case 'object':
                $this->setError('Empty data for '.$field);
                return new \stdClass();
                break;
        }

        $this->setError('Unrecognised data type for '.$field);
        return false;


    }



}