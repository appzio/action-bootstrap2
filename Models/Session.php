<?php

/* here is stuff that COULD be in the Aeaction model, but its hear mainly for security purposes */

namespace Bootstrap\Models;

/**
 * Trait Session
 * @package Bootstrap\Models
 */
trait Session {

    /**
     * @param $route
     * @param bool $persist_route
     * @param bool $actionid
     */
    public function setRoute($route,$persist_route=true,$actionid=false){

        $actionid = $actionid ? $actionid : $this->action_id;

        $persist = 'persist_route_'.$actionid;
        $current = 'current_route_'.$actionid;

        /* save the route to session */
        $this->sessionSet($current, $route);
        $this->sessionSet($persist, $persist_route);

    }

    /**
     * @param $array
     */
    public function sessionSetArray($array){
        if(is_array($array) AND !empty($array)){
            foreach($array as $key=>$value) {
                $this->sessionSet($key,$value);
            }
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function sessionSet($key,$value){
        $this->session_storage[$key] = $value;
    }

    /**
     * @param $key
     * @return bool
     */
    public function sessionGet($key){
        if(isset($this->session_storage[$key])){
            return $this->session_storage[$key];
        } else {
            return false;
        }
    }
}