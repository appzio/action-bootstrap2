<?php

/**
 * This trait contains all the variable related functionality - saving, retrieving, deleting, etc.
 * It is used in the main Bootstrap Model so it can be available in the actions that extend it.
 */

namespace Bootstrap\Models;

use Aevariable;

trait Variables
{

    /* @var $this BootstrapModel */

    /**
     * Return variable id by name
     *
     * @param $varname
     * @return bool
     */
    public function getVariableId($varname)
    {

        if (isset($this->vars[$varname])) {
            return $this->vars[$varname];
        } else {
            return false;
        }
    }

    /**
     * Return variable name by id
     *
     * @param $varid
     * @return bool
     */
    public function getVariableName($varid)
    {

        $vars = array_flip($this->vars);

        if (isset($vars[$varid])) {
            return $vars[$varid];
        } else {
            return false;
        }
    }

    /**
     * Return global variable for app by id
     *
     * @param $varname
     * @return bool
     */
    public function getGlobalVariableByName($varname)
    {

        $var = \AegameKeyvaluestorage::model()->findByAttributes(array('game_id' => $this->appid, 'key' => $varname));

        if (isset($var->value)) {
            return $var->value;
        } else {
            return false;
        }
    }

    /**
     * Save a list of variables
     *
     * @param $variables
     * @param bool $exclude
     * @return bool
     */
    public function saveNamedVariables($variables, $exclude = false)
    {

        $new = array();

        foreach ($variables as $key => $val) {
            if (isset($this->vars[$key])) {
                $id = $this->vars[$key];
                $new[$id] = $val;
            } elseif (!is_numeric($key)) {
                $newvar = Aevariable::addGameVariable($this->appid, $key);
                $new[$newvar] = $val;
            }
        }

        \AeplayVariable::saveVariablesArray($new, $this->playid, $exclude);
        $this->loadVariableContent();
        return true;
    }

    /**
     * Returned saved variable for current user
     * If not stored in memory will be queried from the database
     *
     * @param $varname
     * @param bool $default
     * @return bool
     */
    public function getSavedVariable($varname, $default = false)
    {
        if (isset($this->varcontent[$varname])) {
            return $this->varcontent[$varname];
        }

        $id = $this->getVariableId($varname);

        /* we seem to have a problem of variable not always being available. todo: research why? */

        if ($id) {
            $var = \AeplayVariable::model()->findByAttributes(array('play_id' => $this->playid, 'variable_id' => $id));
            if (isset($var->value)) {
                return $var->value;
            }
        }

        if ($default) {
            return $default;
        }

        return false;
    }

    /**
     * Get all variables for the given application
     *
     * @param $gid
     * @return bool
     */
    public static function getVariables($gid)
    {
        $vars = \Aevariable::model()->findAllByAttributes(array('game_id' => $gid));

        foreach ($vars as $var) {
            $name = $var->name;
            $varnames[$name] = $var->id;
        }

        if (isset($varnames)) {
            return $varnames;
        } else {
            return false;
        }
    }

    /**
     * Get all variables for a user or return false
     *
     * @param $playid
     * @return mixed
     */
    public static function getVariableContent($playid)
    {
        $vars = \AeplayVariable::model()->with('variable')->findAllByAttributes(array('play_id' => $playid));

        foreach ($vars as $var) {
            $name = $var->variable->name;
            $varcontent[$name] = $var->value;
        }

        if (isset($varcontent)) {
            return $varcontent;
        } else {
            return false;
        }
    }

    /**
     * Get a submitted variable by name.
     * Variables are usually submitted when you trigger a "submit-form-content" action
     *
     * @param $varname
     * @param bool $default
     * @return bool
     */
    public function getSubmittedVariableByName($varname, $default = false)
    {
        /* @var $this BootstrapModel */

        $data = $this->submitvariables;
        $var_id = $this->getVariableId($varname);

        if (isset($data[$var_id]) AND $data[$var_id] !== 'false') {
            return $data[$var_id];
        } elseif (isset($data[$varname]) AND $data[$varname] !== 'false') {
            return $data[$varname];
        } elseif ($default) {
            return $default;
        }

        return false;
    }

    /**
     * Returns all submitted variables
     *
     * @return mixed
     */
    public function getAllSubmittedVariables()
    {
        return $this->submitvariables;
    }


    /**
     * Saves all submitted variables. If there is a multiselect, it will convert its values
     * to a json array.
     */

    public function saveAllSubmittedVariables()
    {


        foreach ($this->submitvariables as $key => $var) {

            $parts = explode('_', $key);

            if (isset($parts[0])) {
                if (is_numeric($parts[0]) AND isset($parts[1]) AND in_array($parts[0], $this->vars) AND $var) {
                    $id = $parts[0];
                    $saver[$id][$var] = $var;
                }

                if (is_numeric($parts[0]) AND isset($parts[1]) AND in_array($parts[0], $this->vars)) {
                    unset($this->submitvariables[$key]);
                }
            }
        }

        if (isset($saver)) {
            foreach ($saver as $key => $val) {
                $val = (object)$val;
                $this->submitvariables[$key] = json_encode($val);
            }
        }

        \AeplayVariable::saveVariablesArray($this->submitvariables, $this->playid, $this->appid, 'standard');
    }

    /**
     * Returns all submitted variables with names as key
     *
     * @return array
     */
    public function getAllSubmittedVariablesByName()
    {

        /* depeneding on whether app has variable set or not,
        submit might come as variable id's or names */

        foreach ($this->submitvariables as $key => $var) {
            if (is_numeric($key)) {
                $key = $this->getVariableName($key);
            }

            $output[$key] = $var;
        }

        if (isset($output)) {
            return $output;
        }

        return array();
    }

    /**
     * Save a list of variables for given user
     *
     * @param $vars
     * @param $playid
     * @param bool $exclude
     * @return bool
     */
    public static function saveVariables($vars, $playid, $exclude = false)
    {

        if (is_array($vars)) {
            foreach ($vars as $var_id => $var_value) {
                if (!isset($exclude[$var_id])) {
                    if (is_numeric($var_id)) {
                        \AeplayVariable::updateWithId($playid, $var_id, $var_value);
                    } else {
                        /* deals mainly tags or any other format where
                        the variable value is a list of values */
                        if (stristr($var_id, '_')) {
                            $id = substr($var_id, 0, strpos($var_id, '_'));
                            $fieldname = substr($var_id, strpos($var_id, '_') + 1);
                            $arraysave[$id][$fieldname] = $var_value;
                        }
                    }
                }
            }
        }

        if (isset($arraysave)) {
            foreach ($arraysave as $key => $savebit) {
                \AeplayVariable::updateWithId($playid, $key, $savebit);
            }
        }

        return true;

    }

    /**
     * Save single variable for current active user
     *
     * @param $variable
     * @param $value
     */
    public function saveVariable($variable, $value)
    {
        if (isset($_REQUEST['cache_request']) AND $_REQUEST['cache_request'] == true) {
            return false;
        }

        /* added March 2018, will not save if its already of this value */
        if ($this->getSavedVariable($variable) == $value) {
            return true;
        }

        if (!is_numeric($variable)) {
            $varid = $this->getVariableId($variable);

            if (!$varid AND $value) {
                $new = new \Aevariable;
                $new->game_id = $this->appid;
                $new->name = $variable;
                $new->insert();
                $varid = $new->getPrimaryKey();
            }
        } else {
            $varid = $variable;
        }

        \AeplayVariable::updateWithId($this->playid, $varid, $value);
        $this->loadVariableContent(true);

        return true;
    }

    /**
     * Delete variable for current active user
     *
     * @param $variablename
     * @return void
     */
    public function deleteVariable($variablename)
    {
        \AeplayVariable::deleteWithName($this->playid, $variablename, $this->appid);
        $this->loadVariableContent(true);
    }

    /**
     * Load variables for the application
     *
     * @return void
     */
    public function loadVariables()
    {
        $this->vars = $this->getVariables($this->appid);
    }

    /**
     * Load variable content for the application
     *
     * @param bool $force
     * @return void
     */
    public function loadVariableContent($force = false)
    {
        $this->varcontent = $this->getVariableContent($this->playid);
    }


    /**
     * Retrieve all variables, which belong to a certain "playid"
     * If you intend to use this method without passing a parameter,
     * you may consider referring to $this->varcontent instead
     *
     * @param bool $playid
     * @return array|bool
     */
    public function foreignVariablesGet($playid = false)
    {

        if (empty($playid)) {
            $playid = $this->playid;
        }

        $cachename = 'foreign-variables-' . $playid;
        $cache = \Appcaching::getGlobalCache($cachename);

        if ($cache AND $cache['time'] + 720 > time()) {
            return $cache['values'];
        }

        $vars = \AeplayVariable::getArrayOfPlayvariables($playid);

        $cache_content['time'] = time();
        $cache_content['values'] = $vars;
        \Appcaching::setGlobalCache($cachename, $cache_content);

        return $vars;
    }

    /**
     * Save variable for given user
     *
     * @param string $variablename
     * @param $value
     * @param int $playid
     */
    public function foreignVariableSave(string $variablename, $value, int $playid)
    {
        \AeplayVariable::updateWithName($playid, $variablename, $value, $this->appid);
        $this->loadVariableContent(true);
    }
}