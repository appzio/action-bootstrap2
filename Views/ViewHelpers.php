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

    public function getNickname($content,$age=true){
        $name = isset($content['nickname']) AND $content['nickname'] ? $content['nickname'] : false;

        if($name){
            return $name;
        }

        if(!$name){
            $name = isset($content['name']) ? $content['name'] : false;
        }

        if(!$name){
            $name = isset($content['firstname']) ? $content['firstname'] : false;
        }

        if(!$name){
            $name = isset($content['real_name']) ? $content['real_name'] : false;
        }

        if(stristr($name, ' ')){
            $name = explode(' ', $name);
            $name = $name[0];
        }

        if(!$name){
            $name = '{#anonymous#}';
        }

        if(!$age){
            return $name;
        }

        if(isset($content['age']) AND $content['age']){
            $name .= ', '.$content['age'];
        } elseif(isset($content['birth_year']) AND is_numeric($content['birth_year'])){
            $year = (int) $content['birth_year'];
            $age = date('Y') - $year;
            $name .= ', ' .$age;
        }

        return $name;

    }
}