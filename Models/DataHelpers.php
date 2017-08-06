<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

use function array_flip;
use ThirdpartyServices;

trait DataHelpers {


    /* @var $this BootstrapModel */

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

    /* returns country code based on users location */
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

    public function setUserAddress(){
        $location = ThirdpartyServices::geoAddressTranslation($this->getSavedVariable('lat'), $this->getSavedVariable('lon'), $this->appid);

        if(!$location){
            $this->setError('Location could not be fetched, make sure you have Google API key defined');
        }

        if(isset($location['city'])){ $vars['city'] = $location['city']; }
        if(isset($location['country'])){ $vars['country'] = $location['country']; }
        if(isset($location['county'])){ $vars['county'] = $location['county']; }
        if(isset($location['zip'])){ $vars['zip'] = $location['zip']; }
        if(isset($location['street'])){ $vars['street'] = $location['street']; }

        if(isset($vars)){
            $this->saveNamedVariables($vars);
        }

    }



}