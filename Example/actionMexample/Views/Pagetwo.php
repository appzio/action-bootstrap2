<?php

namespace packages\actionMexample\Views;

class Pagetwo extends View {

    /* @var \packages\actionMexample\Components\Components */
    public $components;
    public $theme;

    public function __construct($obj){
        parent::__construct($obj);
    }

    public function tab1(){
        $this->layout = new \stdClass();
        $this->setTopShadow();

        if($this->getData('mode', 'string') == 'close'){
            $this->layout->scroll[] = $this->getComponentFullPageLoader();
            $this->layout->onload[] = $this->getOnclickCompleteAction();
            return $this->layout;
        }

        $this->layout->scroll[] = $this->getComponentText('Your registration is nearly finished. Just fill these and you are good to go.');
        $fieldlist = $this->getData('fieldlist','array');

        foreach($fieldlist as $field){
            $this->addField_page2($field);
        }

        /* route: Contoller/action. Controller defines the view file. */
        $btn[] = $this->getComponentText('{#finish_registration#}',
            array('style' => 'mreg_btn',
                'onclick' => $this->getOnclickSubmit('done')
            ));

        $this->layout->footer[] = $this->getComponentRow($btn,array('style' => 'mreg_btn_row'));
        return $this->layout;
    }

    public function getDivs(){
        $divs = new \stdClass();
        $divs->countries = $this->components->getDivPhoneNumbers();
        return $divs;
    }

    public function addField_page2($field){
        switch($field){

            case 'mreg_collect_profile_comment':

                $textarea = $this->components->getComponentFormFieldTextArea('',array(
                    'variable' => $this->model->getVariableId('profile_comment'),
                    'hint' => $this->model->getConfigParam('mreg_hint_text_for_profile_comment')
                ));

                $this->layout->scroll[] = $this->components->getShadowBox($textarea);
                break;

        }
    }

    public function getDivider(){
        return $this->getComponentText('',array('style' => 'mreg_divider'));
    }

    private function setTopShadow(){
        $txt[] = $this->getComponentText('');
        $this->layout->header[] = $this->getComponentRow($txt, array(), array(
            'background-color' => $this->color_top_bar_color,
            'parent_style' => 'mreg_top_shadow'
        ));
    }


}