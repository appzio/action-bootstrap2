<?php


namespace Bootstrap\Models;

use function array_flip;
use Bootstrap\Router\BootstrapRouter;
use CActiveRecord;
use Aevariable;
use AeplayVariable;
use function is_string;

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

    /* @var \Localizationapi */
    public $localizationComponent;
    public $submitvariables;
    public $actionobj;

    public $playid;
    public $appid;

    /* @var \Bootstrap\Router\BootstrapRouter */
    public $router;

    public $action_id;
    public $actionid;
    public $menus;

    public $msgcount;
    public $bottom_menu_id;
    public $branchobj;

    /* this is a general place for validation errors that can be read by components */
    public $validation_errors = array();

    public $permanames;
    public $rewriteconfigs;
    public $rewriteactionfield;
    private $current_itemid;

    private $errors;

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
        $this->configobj = @json_decode($this->actionobj->config);
    }

    public function localize($string){
        return $this->localizationComponent->smartLocalize($string);
    }

    public function getCurrentActionPermaname(){
        $permanames = $this->permanames;
        $permanames = array_flip($permanames);

        if(isset($permanames[$this->action_id])){
            return $permanames[$this->action_id];
        }

    }

    /* returns mapping between permanent name & action id */
    public function getActionidByPermaname($name){

        if(isset($this->permanames[$name])){
            return $this->permanames[$name];
        }

        return false;
    }

    /**
     * @param $field -- this you can see from the form, common fields are:
     * - backarrow
     * - hide_subject
     * - hide_menubar
     * - background_image_portrait
     * @param $newcontent
     */

    public function rewriteActionConfigField($field, $newcontent){
        $this->rewriteconfigs[$field] = $newcontent;
    }

    /**
     * you can reconfigure any action properties with this
     *
     * @param $field
     * @param $newcontent
     */

    public function rewriteActionField($field, $newcontent){
        $this->rewriteactionfield[$field] = $newcontent;
    }

    /* this will get the current item id, as triggered initially by menuid.
        ie. if you use for example open-action with id, you should define id like this:
        controller/function/$id
        this id gets saved to session so it will be remembered even though you would have
        different menu commands inside the same context. It is tied to action_id
    */

    public function getItemId(){
        $pointer = 'item_id_'.$this->action_id;

        if($this->getMenuId()){
            $this->current_itemid = $this->getMenuId();
            $this->sessionSet($pointer, $this->current_itemid);
        } elseif($this->sessionGet($pointer)){
            $this->current_itemid = $this->sessionGet($pointer);
        } else {
            $this->current_itemid = false;
        }

        return $this->current_itemid;

    }

    /**
     * @return mixed -- returns the currentlyc called menuid (if any)
     */

    public function getMenuId(){
        return $this->router->getMenuId();
    }


    /**
     * Current action id (not the play action, but the actual configuration object id
     * @return int
     */

    public function getActionId(){
        return $this->action_id;
    }

    public function getValidationError($name){

        if(isset($this->validation_errors[$name])){
            return (string)$this->validation_errors[$name];
        }

        return false;
    }

    public function setError($string){
        $this->errors[] = $string;
    }

    public function getRuntimeErrors(){
        return $this->errors;
    }

    public function flushActionRoutes($actionid=false,$actionpermaname=false){

        if(is_string($actionpermaname)){
            $actionid = $this->getActionidByPermaname($actionpermaname);
        }

        if(!$actionid){
            $actionid = $this->action_id;
        }

        $this->sessionSet('current_route_'.$actionid, '');
        $this->sessionSet('persist_route_'.$actionid, '');
    }



}