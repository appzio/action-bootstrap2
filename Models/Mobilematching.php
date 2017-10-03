<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

use Aegame;
use Aevariable;
use function array_flip;
use function is_numeric;

/**
 * Trait Mobilematching
 * This trait contains basic matching functionality
 *
 * @package Bootstrap\Models
 */
trait Mobilematching {

    /* @var $this BootstrapModel */

    /**
     * Initialize model.
     * This model contains basic matching/unmatching functionality
     *
     * @param bool $otheruserid
     * @param bool $debug
     */
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