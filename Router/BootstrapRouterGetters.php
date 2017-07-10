<?php

namespace Bootstrap\Router;

trait BootstrapRouterGetters {

    /**
     * @return mixed
     */
    public function getViewName()
    {
        return $this->view_name;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->action_name;
    }

    /**
     * @return mixed
     */
    public function getMenuId()
    {
        return $this->menuid;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controller_name;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    public function getViewData()
    {
        return $this->view_data;
    }






}