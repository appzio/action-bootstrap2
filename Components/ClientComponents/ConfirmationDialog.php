<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;

trait ConfirmationDialog {

    /**
     * @param $onclick_yes
     * @param $div
     * @param $text mixed
     * @param array $parameters selected_state, variable, onclick, style
     * @return \stdClass
     */
    public function getComponentConfirmationDialog($onclick_yes,$div,$text=false,$parameters=array()){
        /** @var BootstrapComponent $this */

        if(isset($parameters['title'])){
            $out[] = $this->getComponentText($parameters['title'],array('style' => 'confirmation_title'));
        } else {
            $out[] = $this->getComponentText('{#are_you_sure#}?',array('style' => 'confirmation_title'));
        }

        $out[] = $this->getComponentText('',array('style' => 'confirmation_divider'));

        if(isset($parameters['onclick_cancel'])){
            $onclick_cancel = $parameters['onclick_cancel'];
        } else {
            $onclick_cancel = $this->getOnclickHideDiv($div);
        }

        if($text){
            $out[] = $this->getComponentSpacer(10);
            $out[] = $this->getComponentText($text,array('style' => 'confirmation_dialogtext'));
        }

        if(isset($parameters['title_cancel'])){
            $btn[] = $this->getComponentText($parameters['title_cancel'],array('onclick' =>$onclick_cancel,'style' => 'confirmation_btn'));
        } else {
            $btn[] = $this->getComponentText('{#cancel#}',array('onclick' =>$onclick_cancel,'style' => 'confirmation_btn'));
        }

        $btn[] = $this->getComponentVerticalSpacer('10');
        $btn[] = $this->getComponentText('{#yes#}',array('onclick' =>$onclick_yes,'style' => 'confirmation_btn'));

        $out[] = $this->getComponentRow($btn,array(),array('text-align' => 'center','margin' => '20 20 10 20'));

        return $this->getComponentColumn($out,array('style' => 'confirmationdialog'));





    }

}
