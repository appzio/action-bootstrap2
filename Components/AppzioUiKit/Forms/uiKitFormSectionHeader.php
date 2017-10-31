<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

trait uiKitFormSectionHeader {

    public function uiKitFormSectionHeader($text){
        $out[] = $this->uiKitDivider();
        $text = $this->model->localize($text);
        $out[] = $this->getComponentText(strtoupper($text), array('style'  => 'uikit_formsection_header'));
        $out[] = $this->uiKitDivider();
        return $this->getComponentColumn($out);
    }

}