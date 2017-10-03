<?php


namespace Bootstrap\Models;

use function array_flip;
use Bootstrap\Router\BootstrapRouter;
use CActiveRecord;
use Aevariable;
use AeplayVariable;
use function is_array;
use function is_string;

/**
 * Class BootstrapModel
 *
 * @package Bootstrap\Models
 */
class BootstrapModel extends CActiveRecord {

    use Variables;
    use Session;
    use DataHelpers;
    use Validators;
    use Mobilematching;

    /**
     * Configuration object passed from the parser
     *
     * @var
     */
    public $configobj;

    /**
     * List of variables in name - id pairs.
     * Should be accessed with the methods declared in the Variables trait, not directly.
     *
     * @var
     */
    public $vars;

    /**
     * List of variables in name - value pairs
     * Should be accessed with the methods declared in the Variables trait, not directly.
     *
     * @var
     */
    public $varcontent;

    /**
     * @var
     */
    public $session_storage;

    /**
     * @var
     */
    public $click_parameters_to_save;

    /* @var \Localizationapi */
    public $localizationComponent;

    /**
     * List of submitted variables
     *
     * @var
     */
    public $submitvariables;

    /**
     * Action configuration object
     * @var
     */
    public $actionobj;

    /**
     * Current active user id
     *
     * @var
     */
    public $playid;

    /**
     * Current application id
     *
     * @var
     */
    public $appid;

    /**
     * Not to be confused with playid, this is installation specific id
     * @var
     */
    public $userid;

    /* @var \Bootstrap\Router\BootstrapRouter */
    public $router;

    /**
     * @var
     */
    public $action_id;

    /**
     * @var
     */
    public $actionid;

    /**
     * List of application menus
     *
     * @var
     */
    public $menus;

    /**
     * @var
     */
    public $msgcount;

    /**
     * @var
     */
    public $bottom_menu_id;

    /**
     * Branch configuration object
     *
     * @var
     */
    public $branchobj;

    /**
     * This is a general place for validation errors that can be read by components
     *
     * @var array
     */
    public $validation_errors = array();

    /**
     * Action permanames (slugs) with action id
     *
     * @var
     */
    public $permanames;

    /**
     * @var
     */
    public $rewriteconfigs;

    /**
     * @var
     */
    public $rewriteactionfield;

    /**
     * @var
     */
    private $current_itemid;

    /**
     * Matching model
     *
     * @var
     */
    public $mobilematchingobj;

    /**
     * Matching meta model
     *
     * @var
     */
    public $mobilematchingmetaobj;


    /**
     * You can feed following kind of config array for bottom_menu_config
     * <code>
     * $config['flags']['approvals'] = $this->getAdultNotificationCount();
     * $config['flags']['notifications'] = NotificationsModel::getMyNotificationCount($this->playid);
     * $config['background_color'] = '#ffffff';
     * $config['text_color'] = '#000000';
     * $config['hide_text'] = true;
     * $config['flag_color'] = '#3EB439';
     * $config['flag_text_color'] = '#ffffff';
     * </code>
     */
    public $bottom_menu_config;

    /**
     * @var
     */
    private $errors;

    /**
     * BootstrapModel constructor.
     * @param string $obj
     */
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

    /**
     * @return string
     */
    public function tableName(){
        return 'ae_game_branch_action';
    }

    /**
     * @return string
     */
    public function primaryKey()
    {
        return 'id';
    }

    /**
     * @param string $className
     * @return mixed|static
     */
    public static function model($className=__CLASS__){
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function relations()
    {
        return array(
            'type' => array(self::BELONGS_TO, 'ae_game_branch_action_type', 'type_id'),
        );
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return array(
            'type_id' => '{%task_type%}',
            'name' => '{%task_name%}',
        );
    }

    /**
     * Returns a configuration parameter as defined in action's web configuration panel.
     * You can rewrite any configuration parameters in your action using $this->rewriteActionConfigField('fieldname','newvalue');
     * Typical parameters you would use are: backarrow, background_color, hide_menubar, subject, share_title, share_description,
     * share_image, hide_scrollbar, pull_to_refresh, transparent_statusbar
     * 
     * @param $param
     * @param bool $default
     * @return bool
     */
    public function getConfigParam($param,$default=false){

        if (isset($this->configobj->$param)) {
            return $this->configobj->$param;
        } elseif ($default) {
            return $default;
        }

        return false;
    }

    /**
     * Get validation errors list
     *
     * @return array
     */
    public function getValidationErrors() {
        return $this->validation_errors;
    }

    /**
     * Get list of all configuration parameters
     *
     * @return array
     */
    public function getAllConfigParams(){
        $params = (array)$this->configobj;
        return $params;
    }

    /**
     * Reload all variable data
     *
     * @return void
     */
    public function reloadData(){
        $this->loadVariables();
        $this->loadVariableContent();
        $this->actionobj = \AeplayAction::model()->with('aetask')->findByPk($this->actionid);
        $this->configobj = @json_decode($this->actionobj->config);
    }

    /**
     * Localize string
     *
     * @param $string
     * @return bool|mixed|string
     */
    public function localize($string){
        return $this->localizationComponent->smartLocalize($string);
    }

    /**
     * Get the active action's permaname (slug)
     *
     * @return array
     */
    public function getCurrentActionPermaname(){
        $permanames = $this->permanames;

        if(!is_array($permanames)){
            return array();
        }

        $permanames = array_flip($permanames);

        if(isset($permanames[$this->action_id])){
            return $permanames[$this->action_id];
        }

    }

    /**
     * Returns mapping between permanent name & action id
     *
     * @param $name
     * @return bool
     */
    public function getActionidByPermaname($name){

        if(isset($this->permanames[$name])){
            return $this->permanames[$name];
        }

        return false;
    }

    /**
     * Rewrite configuration field by key
     *
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
     * Reconfigure any action property
     *
     * @param $field
     * @param $newcontent
     */

    public function rewriteActionField($field, $newcontent){
        $this->rewriteactionfield[$field] = $newcontent;
    }

    /**
     * This will get the current item id, as triggered initially by menuid.
     * ie. if you use for example open-action with id, you should define id like this:
     * controller/function/$id
     * this id gets saved to session so it will be remembered even though you would have
     * different menu commands inside the same context. It is tied to action_id
     *
     * @return bool|mixed
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
     * Returns the currentlyc called menuid (if any)
     *
     * @return mixed
     */
    public function getMenuId(){
        return $this->router->getMenuId();
    }


    /**
     * Current action id (not the play action, but the actual configuration object id
     *
     * @return int
     */
    public function getActionId(){
        return $this->action_id;
    }

    /**
     * Return validation error from the list by name
     *
     * @param $name
     * @return bool|string
     */
    public function getValidationError($name){

        if(isset($this->validation_errors[$name])){
            return (string)$this->validation_errors[$name];
        }

        return false;
    }

    /**
     * Add error in the errors object
     *
     * @param $string
     * @return void
     */
    public function setError($string){
        $this->errors[] = $string;
    }

    /**
     * Return errors object
     *
     * @return mixed
     * @return void
     */
    public function getRuntimeErrors(){
        return $this->errors;
    }

    /**
     * Remove routes from the session
     *
     * @param bool $actionid
     * @param bool $actionpermaname
     */
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