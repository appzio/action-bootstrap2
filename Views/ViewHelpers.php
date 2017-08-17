<?php

namespace Bootstrap\Views;

trait ViewHelpers {

    public function actionViewerror(){
        $this->layout = new \stdClass();
        $this->layout->scroll[] = $this->getComponentText('Controller is missing its methods',array(
            'style' => 'router-error-message',
        ));
        return $this->layout;
    }

    public function setError(string $msg){
        $this->errors[] = $msg;
    }



}