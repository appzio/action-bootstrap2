<?php

/*

This is the admin interface configuration for the action. All configuration options
are easily available under model as $this->getConfigParam('param_name');

On this action we use the configuration to determine which fields are active & what
is the login branch. Login branch is important, because registration closes the login
in the end of the registration.

NOTE: all fields are named config[yourfieldname], nothing else will work. You can invent any
field names, these are available when rendering the view (under views/)

supported field types, uses Yii Booster, this would be your best source of information:
http://www.yiiframework.com/forum/index.php/topic/36258-yiibooster/

'text' => 'textFieldRow',
'password' => 'passwordFieldRow',
'textarea' => 'textAreaRow',
'file' => 'fileFieldRow',
'radio' => 'radioButtonRow',
'checkbox' => 'checkBoxRow',
'listbox' => 'dropDownListRow',
'dropdownlist' => 'dropDownListRow',
'checkboxlist' => 'checkBoxListRow',
'radiolist' => 'radioButtonListRow',

//HTML5 types not supported in YiiBooster yet: render as textField
'url' => 'textFieldRow',
'email' => 'textFieldRow',
'number' => 'textFieldRow',

//'range'=>'activeRangeField', not supported yet
'date' => 'datepickerRow',

//new YiiBooster types
'captcha' => 'captchaRow',
'daterange' => 'dateRangeRow',
'redactor' => 'redactorRow',
'markdowneditor' => 'markdownEditorRow',
'uneditable' => 'uneditableRow',
'radiolistinline' => 'radioButtonListInlineRow',
'checkboxlistinline' => 'checkBoxListInlineRow',
'select2' => 'select2Row'

*/

$buttons=array(
    'no_button' => '{%article_no_button%}',
    'submit' =>  '{%article_standard_complete_button%}',
    'save' =>  '{%article_save_button%}',
);

$actions = CHtml::listData(Aeaction::getAllActions($this->gid),'id','name');
$shortname = 'mregister';

if(isset($model->type_id) AND $model->type_id > 0){
    $type = Aeactiontypes::model()->findByPk($model->type_id);
    if(isset($type->shortname)){
        $shortname = $type->shortname;
    }
}

return array(
    'config[subject]' => array('type'=>'text', 'title'=>'%subject%'),
    'config[article_action_theme]' => array('type'=>'dropdownlist','items' => Controller::getActionThemeListing($shortname), 'hint' => '{%hint_article_action_theme%}'),
    'config[button_action]' => array('type'=>'dropdownlist','items' => $buttons, 'hint' => '{%hint_article_button_action%}'),

    // alert
    'config[alertbox]' => array('type'=>'textarea', 'title'=>'%alertbox%'),

    // Configs
    'config[mreg_collect_photo]' => array('type'=>'checkbox'),
    'config[mreg_collect_full_name]' => array('type'=>'checkbox'),
    'config[mreg_collect_nickname]' => array('type'=>'checkbox'),
    'config[mreg_collect_email]' => array('type'=>'checkbox'),
    'config[mreg_email_strict_validation]' => array('type'=>'checkbox'),

    'config[mreg_collect_phone]' => array('type'=>'checkbox'),

    'config[mreg_collect_profile_comment]' => array('type'=>'checkbox'),
    'config[mreg_hint_text_for_profile_comment]' => array('type'=>'textarea'),

    'config[mreg_social_facebook]' => array('type'=>'checkbox'),
    'config[mreg_social_twitter]' => array('type'=>'checkbox'),
    'config[mreg_social_google]' => array('type'=>'checkbox'),
    'config[mreg_social_instagram]' => array('type'=>'checkbox'),

    'config[mreg_collect_terms]' => array('type'=>'checkbox'),
    'config[mreg_terms_action]' => array('type' => 'dropdownlist',
        'items' => $actions,
        'hint' => '{%choose_action_that_holds_terms_and_conditions%}'
    ),

    'config[login_branch]' => array('type'=>'dropdownlist',
        'items' => CHtml::listData(Aegame::getBranches($this->gid),'id','title'),
    ),

    'config[debug_mode]' => array('type'=>'checkbox','hint' => '{%menu_for_submit_button%}'),
);