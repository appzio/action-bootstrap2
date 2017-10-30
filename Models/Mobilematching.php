<?php

namespace Bootstrap\Models;

use Aegame;
use Aevariable;

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

    /* generates a unique chat id between two users */
    public function getTwoWayChatId($id,$playid=false){

        if(!$playid){
            $playid = $this->playid;
        }

        if($id < $playid){
            $chatid = $id.'-chat-'.$playid;
        } else {
            $chatid = $playid.'-chat-'.$id;
        }

        return $chatid;

    }





}