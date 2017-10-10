<?php


namespace Bootstrap\Models;
use ThirdpartyServices;

trait DataHelpers {


    /* @var $this BootstrapModel */

    /**
     * Get country codes from JSON file in name - country code pairs
     *
     * @return array
     */
    public function getCountryCodes(){
        $path = \Yii::getPathOfAlias('application.modules.aelogic.packages.actionMobileregister2.sql');
        $file = $path .'/countrycodes.json';
        $cities = file_get_contents($file);
        $cities = json_decode($cities,true);
        $output = array();

        foreach ($cities['countries'] as $country){
            $name = $country['name'];
            $output[$name] = $country['code'];
        }

        return $output;
    }

    /**
     * Returns country code based on users location
     *
     * @return mixed
     */
    public function getCountryCode(){
        $codes = $this->getCountryCodes();
        
        if(!$this->getSavedVariable('country')){
            $this->setUserAddress();
        }

        $country = $this->getSavedVariable('country');
        array_flip($codes);

        if(isset($codes[$country])){
            return $codes[$country];
        }
    }

    /**
     * Set current user address
     *
     * @return bool
     */
    public function setUserAddress(){
        if(!$this->getSavedVariable('lat')){
            return false;
        }

        $location = ThirdpartyServices::geoAddressTranslation($this->getSavedVariable('lat'), $this->getSavedVariable('lon'), $this->appid);

        if(!$location){
            //$this->setError('Location could not be fetched, make sure you have Google API key defined');
        }

        if(isset($location['city'])){ $vars['city'] = $location['city']; }
        if(isset($location['country'])){ $vars['country'] = $location['country']; }
        if(isset($location['county'])){ $vars['county'] = $location['county']; }
        if(isset($location['zip'])){ $vars['zip'] = $location['zip']; }
        if(isset($location['street'])){ $vars['street'] = $location['street']; }

        if(isset($vars)){
            $this->saveNamedVariables($vars);
        }

        $this->reloadData();
    }

    /**
     * Find play based on two different variables
     *
     * @param $var1
     * @param $var2
     * @param $var1_value
     * @param $var2_value
     */
    public function findPlayFromVariables($var1,$var2,$var1_value,$var2_value){

        $sql = "SELECT tbl1.play_id,tbl1.value,tbl2.value FROM ae_game_play_variable AS tbl1
                LEFT JOIN ae_game_play_variable AS tbl2 ON tbl1.play_id = tbl2.play_id

                LEFT JOIN ae_game_variable AS vartable1 ON tbl1.variable_id = vartable1.id
                LEFT JOIN ae_game_variable AS vartable2 ON tbl2.variable_id = vartable2.id

                WHERE tbl1.`value` = :var1_value
                AND tbl2.`value` = :var2_value
                AND vartable1.name = :var1_name
                AND vartable2.name = :var2_name
                AND vartable1.game_id = :gid
                AND vartable2.game_id = :gid

                ORDER BY tbl1.play_id DESC
                ";


        $rows = \Yii::app()->db
            ->createCommand($sql)
            ->bindValues(array(
                ':var1_value' => $var1_value,
                ':var2_value' => $var2_value,
                ':var1_name' => $var1,
                ':var2_name' => $var2,
                ':gid' => $this->appid
            ))
            ->queryAll();

        if(isset($rows[0]['play_id'])){
            return $rows[0]['play_id'];
        }

        return false;
    }


    /**
     * Note: this will return only the latest user with this value & it will exclude
     * the current user by default
     *
     * @return mixed
    */
    public function findPlayFromVariable($varname,$varvalue,$include_current_user=false){

        if($include_current_user){
            $add = '';
        } else {
            $add = 'AND tbl1.play_id <>' .$this->playid;
        }

        $sql = "SELECT tbl1.play_id,tbl1.value,tbl2.value FROM ae_game_play_variable AS tbl1
                LEFT JOIN ae_game_play_variable AS tbl2 ON tbl1.play_id = tbl2.play_id

                LEFT JOIN ae_game_variable AS vartable1 ON tbl1.variable_id = vartable1.id

                WHERE tbl2.`value` = :varvalue
                AND vartable1.game_id = :gid
                AND vartable1.name = :varname
                $add
              
                ORDER BY tbl1.play_id DESC
                ";


        $rows = \Yii::app()->db
            ->createCommand($sql)
            ->bindValues(array(
                ':varname' => $varname,
                ':varvalue' => $varvalue,
                ':gid' => $this->appid
            ))
            ->queryAll();

        if(isset($rows[0]['play_id'])){
            return $rows[0]['play_id'];
        }

        return false;
    }

    public function getActionThemeByPermaname($permaname){
        $cachename = 'theme'.$permaname.$this->appid;
        $cache = \Appcaching::getGlobalCache($cachename);

        if($cache){
            return $cache;
        }

        \Appcaching::getAppCache('theme'.$permaname, $this->appid);

        $id = $this->getActionidByPermaname($permaname);
        if($id){
            $config = \Aeaction::getActionConfig($id);
            if(isset($config->article_action_theme) AND $config->article_action_theme){
                \Appcaching::setGlobalCache($cachename, $config->article_action_theme,1200);
                return $config->article_action_theme;
            }
        }
    }
}