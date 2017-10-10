<?php


namespace Bootstrap\Models;

use Bootstrap\Router\BootstrapRouter;
use CActiveRecord;
use Aevariable;
use AeplayVariable;
use packages\actionMnotifications\Models\NotificationsModel as NotificationsModel;

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
     * Actions configuration as defined in the web admin. All these can be overriden using $this->rewriteActionConfigField()
     *
     * @var
     */
    public $configobj;

    /**
     * Array of currently loaded user variables in name - id pairs.
     * Should be accessed with the methods declared in the Variables trait, not directly.
     * Declared public for easier debugging for certain cases.
     *
     * @var
     */
    public $vars;

    /**
     * Includes currently loaded user variables in array. Normally you would use $this->getSavedVariable instead of accessing this directly.
     * Declared public for easier debugging for certain cases.
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
     * Array containing the submitted variables for a certain request.
     * Submitting a form using a "submit-form-content" action will allow you to access all of the form variables from this array.
     * Usually retrieved with getAllSubmittedVariables() or getSubmittedVariableByName() methods.
     * Should be used in the model for validation and storing.
     *
     * @var
     */
    public $submitvariables;

    /**
     * Array containing the configuration specified in the web admin.
     * Fields can be rewritten using the rewriteActionField() method
     * @var
     */
    public $actionobj;

    /**
     * Currently logged in user id
     *
     * @var
     */
    public $playid;

    /**
     * Current active application id
     *
     * @var
     */
    public $appid;

    /**
     * Not to be confused with playid, this is installation specific id - the phone on which the app is installed
     *
     * @var
     */
    public $userid;

    /**
     * Router object instance. This is the object that instantiates the controller and wires up the view depending on the called route.
     *
     * @var \Bootstrap\Router\BootstrapRouter
     */
    public $router;

    /**
     * Id of the action in the web admin
     *
     * @var
     */
    public $action_id;

    /**
     * Id of the currently active action
     *
     * @var
     */
    public $actionid;

    /**
     * Array containing all of the application menus.
     * An application can have multiple menus defined for different purposes and used in different places in the app - side, top, bottom.
     *
     * @var
     */
    public $menus;

    /**
     * @var
     */
    public $msgcount;

    /**
     * Id of the application bottom menu
     *
     * @var
     */
    public $bottom_menu_id;

    /**
     * Configuration array for the branch. Includes all configuration fields defined in the web admin.
     *
     * @var
     */
    public $branchobj;

    /**
     * This is a general place for storing validation errors.
     * Usually used from the controller for conditional checks and to display errors.
     *
     * @var array
     */
    public $validation_errors = array();

    /**
     * Array consisting of action permanames (slugs) - action id pairs
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
     * The model containing the matching related functionality.
     * Matching is used not only in dating applications but in all other apps that have similar business logic
     * i.e. tenants and properties
     *
     * @var \MatchingMobileproperties
     */
    public $mobilematchingobj;

    /**
     * Matching meta model
     *
     * @var Mobilematching;
     */
    public $mobilematchingmetaobj;

    /**
     * This is used for Notifications action, making it very easy to register push & email notifications.
     * Register a new notification like this:
     * <code>
     * $this->mobile_notifications->addNotification(array(
     *
     * to_playid=false,
     *
     * to_email=false,
     *
     * subject = '',
     *
     * $msg='',
     *
     * action_id=false,
     *
     * action_param='',
     *
     * image='',
     *
     * type='invitation'
     *
     * </code>
     *
     * You can show the notifications of the user with Mobile Notificiations action. You can configure additional
     *
     * @var NotificationsModel;
     */
    public $notifications;

    /**
     * You can feed following kind of config array for bottom_menu_config
     * <code>
     * $config['flags']['approvals'] = $this->getAdultNotificationCount();
     *
     * $config['flags']['notifications'] = NotificationsModel::getMyNotificationCount($this->playid);
     *
     * $config['background_color'] = '#ffffff';
     *
     * $config['text_color'] = '#000000';
     *
     * $config['hide_text'] = true;
     *
     * $config['flag_color'] = '#3EB439';
     *
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

        /**
         * init mobile notifications
         *
         */

        $theme = $this->getActionThemeByPermaname('notifications');

        /* sets theme specific model */
        if($theme){
            $namespace = 'packages\actionMnotifications\themes\\' .$theme .'\Models\NotificationsModel';

            if(class_exists($namespace)){
                $this->notifications = new $namespace;
            } else {
                $this->notifications = new NotificationsModel;
            }

            $this->notifications->theme = $this->configobj->article_action_theme;
        } else {
            $this->notifications = new NotificationsModel;
        }

        $this->notifications->playid = $this->playid;
        $this->notifications->app_id = $this->appid;
        $this->notifications->model = $this;


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
     * Get an array of validation errors.
     * Errors are usually filled in from the model upon form validation.
     *
     * @return array
     */
    public function getValidationErrors() {
        return $this->validation_errors;
    }

    /**
     * Returns an associative array of the configuration object.
     *
     * @return array
     */
    public function getAllConfigParams(){
        $params = (array)$this->configobj;
        return $params;
    }

    /**
     * Reloads all variable data and action data
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
     * Localize a string
     *
     * @param $string
     * @return bool|mixed|string
     */
    public function localize($string){
        return $this->localizationComponent->smartLocalize($string);
    }

    /**
     * Get the active action's permaname (slug) if it is set
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
     * This will extract numeric part separate from the menuid and
     * return parts for the menu string & numeric values separately.
     *
     * @return array
     */

    public function getItemParts(){
        $id = $this->getItemId();
        $default = array('string' => '','id' => '');
        preg_match('/_\d.*/', $id,$numeric);

        if(!isset($numeric[0])){
            return $default;
        }

        $text = str_replace($numeric[0], '', $id);
        $numeric = str_replace('_', '', $numeric[0]);
        if($numeric AND $text){
            return array('string' => $text,'id' => $numeric);
        }

        return $default;

    }

    /**
     * Returns the currently called menuid if set
     *
     * @return mixed
     */
    public function getMenuId(){
        return $this->router->getMenuId();
    }


    /**
     * Current action id (not the play action, but the actual configuration object id)
     *
     * @return int
     */
    public function getActionId(){
        return $this->action_id;
    }

    /**
     * Return validation error from the array by name
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

    /**
     * Used by infinite scrolling content. So if action is refreshed with this id set,
     * you should return the next batch of content.
     * @return bool
     */
    public function getNextPageId(){
        if(isset($_REQUEST['next_page_id'])){
            return $_REQUEST['next_page_id'];
        }

        return false;
    }
}