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

    /**
     * Simple helper that will return either white or black color depending on the given color
     * @param $bgcolor
     * Color to check for
     * @return string
     * Returns either #000000 or #ffffff
     */
    public function getTextColorForBackground($bgcolor){
            return (hexdec($bgcolor) > 0xffffff/2) ? '#000000':'#ffffff';
    }
}