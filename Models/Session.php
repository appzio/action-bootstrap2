<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

trait Session {


    public function sessionSetArray($array){
        if(is_array($array) AND !empty($array)){
            foreach($array as $key=>$value) {
                $this->sessionSet($key,$value);
            }
        }
    }

    public function sessionSet($key,$value){
        $this->session_storage[$key] = $value;
    }

    public function sessionGet($key){
        if(isset($this->session_storage[$key])){
            return $this->session_storage[$key];
        } else {
            return false;
        }
    }





}