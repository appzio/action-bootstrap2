<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

use Aegame;
use Aevariable;
use function array_flip;
use function is_numeric;

trait Mobilematching {

    /* @var $this BootstrapModel */

    public function initMobileMatching($otheruserid=false,$debug=false){
        \Yii::import('application.modules.aelogic.packages.actionMobilematching.models.*');
        $this->mobilematchingobj = new \MobilematchingModel();
        $this->mobilematchingobj->playid_thisuser = $this->playid;
        $this->mobilematchingobj->playid_otheruser = $otheruserid;
        $this->mobilematchingobj->gid = $this->appid;
        $this->mobilematchingobj->actionid = $this->actionid;
        $this->mobilematchingobj->uservars = $this->varcontent;
        $this->mobilematchingobj->factoryInit($this);
        $this->mobilematchingobj->initMatching($otheruserid,true);
        $this->mobilematchingmetaobj = new \MobilematchingmetaModel();
    }




}