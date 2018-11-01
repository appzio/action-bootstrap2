<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Components\BootstrapComponent as BootstrapComponent;

trait uiKitFormSettingsField {

    public function uiKitFormSettingsField(array $parameters=[],$styles=[]){
        /** @var BootstrapComponent $this */

        $title = $this->addParam('title', $parameters,'{#missing_name#}');
        $icon = $this->addParam('icon', $parameters,false);
        $onclick = $this->addParam('onclick', $parameters,false);
        $description = $this->addParam('description', $parameters,false);
        $clicker_element = $this->addParam('clicker_element', $parameters,false);

        $description_style['font-size'] = isset($styles['font-size']) ? $styles['font-size']-4 : 12;
        $description_style['opacity'] = 0.6;
        $description_style['margin'] = '5 0 0 0';
        $description_style['color'] = isset($styles['color']) ? $styles['color'] : $this->color_text_color;

        $title_style['font-size'] = isset($styles['font-size']) ? $styles['font-size'] : 14;
        $title_style['color'] = $this->color_text_color;

        $margin = isset($styles['margin']) ? $styles['margin'] : '0 15 0 15';
        $padding = isset($styles['padding']) ? $styles['padding'] : '5 0 10 0';
        $height = isset($styles['height']) ? $styles['height'] : 60;


        if(strlen($description) > 45){
            $description = wordwrap($description,45,'<cut>');
            $description = explode('<cut>', $description);
            $description = $description[0] .'...';
        }

        if($description){
            $text[] = $this->getComponentText($title,[],$title_style);
            $text[] = $this->getComponentText($description,[],$description_style);
            $row[] = $this->getComponentColumn($text,[],[]);
        } else {
            $row[] = $this->getComponentText($title,[],$title_style);
        }

        if($clicker_element){
            $row[] = $clicker_element;
        } else {
            $row[] = $this->getComponentImage('formkit-selector-arrow-fwd.png',[],[
                'floating' => 1,'float' => 'right','height' => '18','opacity' => '0.8'
            ]);
        }

        $col[] = $this->getComponentRow($row,[],[
            'vertical-align' => 'middle',
            'padding' => $padding]);

        if($onclick){
            $line = $this->getComponentColumn($col, ['onclick' => $onclick], [
                'vertical-align' => 'middle',
                'margin' => $margin,
                'height' => $height]);
        } else {
            $line = $this->getComponentColumn($col, [], [
                'vertical-align' => 'middle',
                'margin' => $margin,
                'height' => $height]);
        }

        if($icon){
            $output[] = $this->getComponentImage($icon,[],['height' => '30','margin' => '0 0 0 15']);
            $output[] = $line;
            return $this->getComponentRow($output,[],['vertical-align' => 'middle','height' => $height,'width' => '100%']);
        } else {
            return $line;
        }


    }

}