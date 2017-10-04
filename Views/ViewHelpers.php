<?php

namespace Bootstrap\Views;

trait ViewHelpers {

    /**
     * @return \stdClass
     */
    public function actionViewerror(){
        $this->layout = new \stdClass();
        $this->layout->scroll[] = $this->getComponentText('Controller is missing its methods',array(
            'style' => 'router-error-message',
        ));
        return $this->layout;
    }

    /**
     * @param string $msg
     */
    public function setError(string $msg){
        $this->errors[] = $msg;
    }
}