<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Models\BootstrapModel;

trait uiKitSearchField {

    public function uiKitSearchField(array $parameters=array()){
        /** @var BootstrapModel $this->model */

        if(isset($parameters['onclick_close'])){
            $close = $parameters['onclick_close'];
        } else {
            $close = $this->getOnclickSubmit('publiclisting/default/cancelsearch');
        }

        if(isset($parameters['onclick_submit'])){
            $submit = $parameters['onclick_submit'];
        } else {
            $submit = 'Publiclisting/default/search';
        }

        $row[] = $this->getComponentImage('search-icon-for-field.png',array(),array('height' => '20'));

        if($this->model->getMenuId() == 'cancelsearch'){
            $val = '';
        } else {
            $val = $this->model->getSubmittedVariableByName('searchterm');
        }

        $row[] = $this->getComponentFormFieldText($val,array(
            'style' => 'akit_searchbox_text',
            'value' => $val,
            'hint' => '{#search#}',
            'variable' => 'searchterm',
//            'id' => 1,
            'submit_menu_id' => $submit,
            'suggestions_style_row' => 'akit_list_row',
            'suggestions_text_style' => 'akit_list_text',
            'submit_on_entry' => '1',
            //'activation' => 'initially'
        ));

        $right[] = $this->getComponentLoader(array('style' => 'akit_loader','visibility' => 'onloading'));
        $right[] = $this->getComponentImage('uikit-delete-icongrey.png',array('onclick' => $close),array('width'=>'20'));
        $row[] = $this->getComponentRow($right,array(),array('margin' => '0 0 0 0','floating' => 1,'float' => 'right'));

        return $this->getComponentRow($row,array(),array('background-color' => "#ffffff",'vertical-align' => 'middle','padding'=> '5 15 5 15'));
    }

}