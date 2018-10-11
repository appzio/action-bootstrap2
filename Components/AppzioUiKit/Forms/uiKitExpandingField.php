<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

use Bootstrap\Components\BootstrapComponent as BootstrapComponent;

trait uiKitExpandingField
{

    public function uiKitExpandingField($parameters)
    {
        /** @var BootstrapComponent $this */

        $title = $this->addParam('title', $parameters,'');
        $value = $this->addParam('value', $parameters,$title);
        $variable = $this->addParam('variable', $parameters,'');
        $icon = $this->addParam('icon', $parameters,false);
        $expanding_content = $this->addParam('expanding_content', $parameters,false);

        $params_initial['variable'] = $variable;
        $params_initial['hint'] = $title;
        $params_initial['style'] = 'uikit-general-field-text';

        if ($icon) {
            $col[] = $this->getComponentImage($icon, array('style' => 'uikit-general-field-icon'));
        } else {
            $col[] = $this->getComponentText('', array('style' => 'uikit-general-field-icon'));
        }

        $col[] = $this->getComponentText($value, $params_initial);

        if (isset($this->model->validation_errors[$variable])) {
            $error = $this->model->validation_errors[$variable];
        } elseif(isset($parameters['error']) AND $parameters['error']){
            $error = $parameters['error'];
        } else {
            $error = false;
        }

        $onclick_hide[] = $this->getOnclickHideElement($variable.'-arrow-off');
        $onclick_hide[] = $this->getOnclickHideElement($variable.'-row-off');
        $onclick_hide[] = $this->getOnclickShowElement($variable.'-arrow-on');
        $onclick_hide[] = $this->getOnclickShowElement($variable.'-row-on');
        $onclick_hide[] = $this->getOnclickHideElement($variable.'-element-on');

        $onclick_show[] = $this->getOnclickShowElement($variable.'-arrow-off');
        $onclick_show[] = $this->getOnclickShowElement($variable.'-row-off');
        $onclick_show[] = $this->getOnclickHideElement($variable.'-arrow-on');
        $onclick_show[] = $this->getOnclickHideElement($variable.'-row-on');
        $onclick_show[] = $this->getOnclickHideElement($variable.'-element-on');

        $col_hidden = $col;

        $col[] = $this->getComponentImage('uikit-icon-fieldarrow.png',[
            'id' => $variable.'-arrow-off'
        ],[
            'floating' => 1,'float' => 'right','width' => '25']);

        $col_hidden[] =  $this->getComponentImage('uikit-icon-fieldarrow-down.png',[
            'visibility' => 'hidden','id' => $variable.'-arrow-on'
        ],[
            'floating' => 1,'float' => 'right','width' => '25']);


        $output[] = $this->getComponentRow($col, ['id' => $variable.'-row-off','onclick' => $onclick_show], ['vertical-align' => 'middle']);
        $output[] = $this->getComponentRow($col_hidden, ['id' => $variable.'-row-on','visibility' => 'hidden','onclick' => $onclick_hide], ['vertical-align' => 'middle']);
        $output[] = $this->uiKitExpandingFieldField($parameters);
        $output[] = $this->uiKitDivider();
        return $this->getComponentColumn($output);

        if (isset($parameters['divider']) AND $parameters['divider']) {
            if($error){
                $output[] = $this->getComponentRow($col, ['id' => $variable.'-row-off','onclick' => $onclick_show], ['vertical-align' => 'middle']);
                $output[] = $this->getComponentRow($col_hidden, ['id' => $variable.'-row-on','visibility' => 'hidden','onclick' => $onclick_hide], ['vertical-align' => 'middle']);
                $output[] = $this->uiKitExpandingFieldField($parameters);
                $output[] = $this->uiKitDividerError();
                $output[] = $this->uiKitFormErrorText($error);
            } else {
                $output[] = $this->getComponentRow($col, ['id' => $variable.'-row-off','onclick' => $onclick_show], ['vertical-align' => 'middle']);
                $output[] = $this->getComponentRow($col_hidden, ['id' => $variable.'-row-on','visibility' => 'hidden','onclick' => $onclick_hide], ['vertical-align' => 'middle']);
                $output[] = $this->uiKitExpandingFieldField($parameters);
                $output[] = $this->uiKitDivider();
            }

        } elseif($error) {
            $row[] = $this->getComponentRow($col, array(), array('vertical-align' => 'middle'));
            $output[] = $this->uiKitExpandingFieldField($parameters);
            $row[] = $this->getComponentText($error, array('style' => 'uikit-general-field-error'));
        } else {
            $output[] = $this->uiKitExpandingFieldField($parameters);
            $output[] = $this->getComponentRow($col, array(), array('vertical-align' => 'middle'));
        }

        return $this->getComponentColumn($output);
    }

    public function uiKitExpandingFieldField($parameters){
        $title = $this->addParam('title', $parameters,'');
        $value = $this->addParam('value', $parameters,$title);
        $variable = $this->addParam('variable', $parameters,'');
        $icon = $this->addParam('icon', $parameters,false);
        $expanding_content = $this->addParam('expanding_content', $parameters,false);

        return $this->getComponentColumn([$expanding_content],[
            'id' => $variable.'-element-on',
            //'visibility' => 'hidden'
        ],['margin' => '0 0 5 0']);


    }

}