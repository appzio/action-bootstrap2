<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Components\BootstrapComponent as BootstrapComponent;

trait uiKitFormSettingsField {

    public function uiKitFormSettingsField(array $parameters=array()){
        /** @var BootstrapComponent $this */

        $title = $this->addParam('title', $parameters,'{#missing_name#}');
        $icon = $this->addParam('icon', $parameters,false);
        $onclick = $this->addParam('onclick', $parameters,false);
        $description = $this->addParam('description', $parameters,false);

        if(strlen($description) > 45){
            $description = wordwrap($description,45,'<cut>');
            $description = explode('<cut>', $description);
            $description = $description[0] .'...';
        }

        if($description){
            $text[] = $this->getComponentText($title,[],['font-size' => '14']);
            $text[] = $this->getComponentText($description,[],['font-size' => '12','opacity' => '0.6','margin' => '5 0 0 0']);
            $row[] = $this->getComponentColumn($text,[],[]);
        } else {
            $row[] = $this->getComponentText($title,[],['vertical-align' => 'middle','font-size' => '14']);
        }
        $row[] = $this->getComponentImage('formkit-selector-arrow-fwd.png',[],[
            'floating' => 1,'float' => 'right','height' => '18','opacity' => '0.8'
        ]);


        $col[] = $this->getComponentRow($row,[],['vertical-align' => 'middle','margin' => '5 0 10 0']);

        if($icon){
            $width = $this->screen_width - 75;
        } else {
            $width = $this->screen_width - 30;
        }

        if($onclick){
            $line = $this->getComponentColumn($col, ['onclick' => $onclick], [
                'vertical-align' => 'middle',
                'margin' => '0 15 0 15',
                'width' => $width,
                'height' => '60']);
        } else {
            $line = $this->getComponentColumn($col, [], [
                'vertical-align' => 'middle',
                'margin' => '0 15 0 15',
                'width' => $width,
                'height' => '60']);
        }

        if($icon){
            $output[] = $this->getComponentImage($icon,[],['height' => '30','margin' => '0 0 0 15']);
            $output[] = $line;
            return $this->getComponentRow($output,[],['vertical-align' => 'middle','height' => 60]);
        } else {
            return $line;
        }


    }

}