<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

use Aegame;
use Aevariable;
use function array_flip;
use function is_numeric;

trait Variables {


    /* @var $this BootstrapModel */

    public function getVariableId($varname){

        if(isset($this->vars[$varname])){
            return $this->vars[$varname];
        } else {
            return false;
        }
    }


    public function getVariableName($varid){

        $vars = array_flip($this->vars);

        if(isset($vars[$varid])){
            return $vars[$varid];
        } else {
            return false;
        }
    }




    public function saveNamedVariables($variables,$exclude=false){

        $new = array();

        foreach($variables as $key=>$val){
            if(isset($this->vars[$key])){
                $id = $this->vars[$key];
                $new[$id] = $val;
            } elseif(!is_numeric($key)) {
                $newvar = Aevariable::addGameVariable($this->appid, $key);
                $new[$newvar] = $val;
            }
        }

        \AeplayVariable::saveVariablesArray($new,$this->playid,$exclude);
        $this->loadVariableContent();
        return true;
    }

    public function getSavedVariable($varname,$default=false){

        if (isset($this->varcontent[$varname])) {
            return $this->varcontent[$varname];
        } elseif ($default) {
            return $default;
        }

        return false;
    }

    public static function getVariables($gid){
        $vars = \Aevariable::model()->findAllByAttributes(array('game_id' => $gid));

        foreach ($vars as $var) {
            $name = $var->name;
            $varnames[$name] = $var->id;
        }

        if(isset($varnames)){
            return $varnames;
        } else {
            return false;
        }
    }

    public static function getVariableContent($playid){
        $vars = \AeplayVariable::model()->with('variable')->findAllByAttributes(array('play_id' => $playid));

        foreach($vars as $var){
            $name = $var->variable->name;
            $varcontent[$name] = $var->value;
        }

        if(isset($varcontent)){
            return $varcontent;
        } else {
            return false;
        }
    }


    public function getSubmittedVariableByName($varname,$default=false)
    {

        /* @var $this BootstrapModel */

        if (isset($this->submitvariables[$this->getVariableId($varname)])) {
            return $this->submitvariables[$this->getVariableId($varname)];
        } elseif(isset($this->submitvariables[$varname])){
            return $this->submitvariables[$varname];
        } elseif ($default) {
            return $default;
        }

        return false;
    }

    public function getAllSubmittedVariables(){
        return $this->submitvariables;
    }

    public function getAllSubmittedVariablesByName(){

        /* depeneding on whether app has variable set or not,
        submit might come as variable id's or names */

        foreach($this->submitvariables as $key=>$var){
            if(is_numeric($key)){
                $key = $this->getVariableName($key);
            }

            $output[$key] = $var;
        }

        if(isset($output)){
            return $output;
        }

        return array();
    }



    public static function saveVariables($vars,$playid,$exclude=false){

        if(is_array($vars)){
            foreach ($vars as $var_id => $var_value) {
                if(!isset($exclude[$var_id])){
                    if(is_numeric($var_id)){
                        \AeplayVariable::updateWithId($playid, $var_id, $var_value);
                    } else {
                        /* deals mainly tags or any other format where
                        the variable value is a list of values */
                        if(stristr($var_id,'_')){
                            $id = substr($var_id,0,strpos($var_id,'_'));
                            $fieldname=substr($var_id,strpos($var_id,'_')+1);
                            $arraysave[$id][$fieldname] = $var_value;
                        }
                    }
                }
            }
        }

        if(isset($arraysave)){
            foreach ($arraysave as $key=>$savebit){
                \AeplayVariable::updateWithId($playid, $key, $savebit);
            }
        }

        return true;

    }

    public function saveVariable($variable,$value){
        if ( !is_numeric($variable) ) {
            $varid = $this->getVariableId($variable);

            if(!$varid AND $value){
                $new = new \Aevariable;
                $new->game_id = $this->appid;
                $new->name = $variable;
                $new->insert();
                $varid = $new->getPrimaryKey();
            }
        } else {
            $varid = $variable;
        }

        \AeplayVariable::updateWithId($this->playid,$varid,$value);
        $this->loadVariableContent(true);
    }

    public function deleteVariable($variablename){
        \AeplayVariable::deleteWithName($this->playid,$variablename,$this->appid);
        $this->loadVariableContent(true);
    }

    public function loadVariables(){
        $this->vars = $this->getVariables($this->appid);
    }

    public function loadVariableContent($force=false){
        $this->varcontent = $this->getVariableContent($this->appid);
    }


    /*
    * Retrieve all variables, which belong to a certain "playid"
    * If you intend to use this method without passing a parameter,
    * you may consider referring to $this->varcontent instead
    */

    public function foreignVariablesGet( $playid = false ) {

        if ( empty($playid) ) {
            $playid = $this->playid;
        }

        $cache = \Appcaching::getUserCache($playid,$this->appid,'playvariables');

        if ( $cache ) {
            return $cache;
        }

        $vars = \AeplayVariable::getArrayOfPlayvariables($playid);
        \Appcaching::setUserCache($playid,$this->appid,'playvariables',$vars);

        return $vars;
    }


    public function foreignVariableSave( string $variablename, $value, int $playid ){
        \AeplayVariable::updateWithName( $playid, $variablename, $value, $this->appid );
        $this->loadVariableContent(true);
    }




}