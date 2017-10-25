<?php

namespace Bootstrap\Components\AppzioUiKit\Text;

trait uiKitTextBlock {

    public function uiKitTextBlock($text){
        $col[] = $this->getComponentText($text, array(),array(
            'margin' => '15 15 15 15',
            'font-size' => '16'
        ));
        $col[] = $this->uiKitDivider();
        return $this->getComponentColumn($col);
    }
    


}