<?php


namespace Bootstrap\Models;

use CActiveRecord;
use Aevariable;
use AeplayVariable;

class BootstrapModel extends CActiveRecord {

    use Variables;
    use Session;
    use DataHelpers;
    use Validators;

    public $configobj;
    public $vars;
    public $varcontent;
    public $session_storage;
    public $click_parameters_to_save;

    public $submitvariables;

    public $playid;
    public $appid;

    /* this is a general place for validation errors that can be read by components */
    public $validation_errors = array();

    public function __construct($obj){

        parent::__construct();
        /* this exist to make the referencing of
        passed objects & variables easier */

        while($n = each($this)){
            $key = $n['key'];
            if(isset($obj->$key) AND !$this->$key){
                $this->$key = $obj->$key;
            }
        }
    }

    public function tableName(){
        return 'ae_game_branch_action';
    }

    public function primaryKey()
    {
        return 'id';
    }

    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'type' => array(self::BELONGS_TO, 'ae_game_branch_action_type', 'type_id'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'type_id' => '{%task_type%}',
            'name' => '{%task_name%}',
        );
    }

    public function getConfigParam($param,$default=false){

        if (isset($this->configobj->$param)) {
            return $this->configobj->$param;
        } elseif ($default) {
            return $default;
        }

        return false;
    }

    public function getValidationErrors() {
        return $this->validation_errors;
    }

    public function getAllConfigParams(){
        $params = (array)$this->configobj;
        return $params;
    }

    /* reload all variable data */
    public function reloadData(){
        $this->loadVariables();
        $this->loadVariableContent();
        $this->actionobj = \AeplayAction::model()->with('aetask')->findByPk($this->actionid);
        $this->configobj = json_decode($this->actionobj->config);
    }

}