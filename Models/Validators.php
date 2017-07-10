<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

trait Validators {

    /* @var $this BootstrapModel */

    public function validateEmail($email){

        if ( empty($email) ) {
            return false;
        }

        $validator = new \CEmailValidator;
        $validator->checkMX = true;

        $email = rtrim( $email );

        // Email must contain only lowercase letters
        if ( preg_match('/[A-Z]/', $email) ) {
            return false;
        }

        if ($validator->validateValue($email)) {
            return true;
        }

        return false;
    }

    public function validateWebsite($url){
        if(strlen($url) < 4){
            return false;
        }

        if(!stristr($this->getSavedVariable('website'),'http')){
            $url = 'http://'.$url;
        }

        $url = parse_url($url);
        if (!isset($url["host"])) return false;
        return !(gethostbyname($url["host"]) == $url["host"]);
    }

    public function validatePassword($password,$strict=false){
        if($strict){
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);

            if(!$uppercase || !$lowercase || !$number || strlen($password) < 8) {
                return false;
            }
        }

        if(strlen($password) > 3){
            return true;
        }

        return false;

    }




}