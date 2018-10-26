<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

use Bootstrap\Components\BootstrapComponent as BootstrapComponent;

trait uiKitExpandingField
{

    public function uiKitExpandingField($parameters = [])
    {
        /** @var BootstrapComponent $this */

        $title = $this->addParam('title', $parameters, '');
        $value = $this->addParam('value', $parameters, $title);
        $variable = $this->addParam('variable', $parameters, '');
        $variable2 = $this->addParam('variable2', $parameters, '');
        $var_separator = $this->addParam('var_separator', $parameters, '');
        $icon = $this->addParam('icon', $parameters, false);

        $params_initial['hint'] = $title;
        $params_initial['style'] = 'uikit-general-field-text';

        if ($icon) {
            $col[] = $this->getComponentImage($icon, array('style' => 'uikit-general-field-icon'));
        } else {
            $col[] = $this->getComponentText('', array('style' => 'uikit-general-field-icon'));
        }

        $col[] = $this->getComponentText($title, $params_initial);

        if (isset($this->model->validation_errors[$variable])) {
            $error = $this->model->validation_errors[$variable];
        } elseif (isset($parameters['error']) AND $parameters['error']) {
            $error = $parameters['error'];
        } else {
            $error = false;
        }

        $onclick_show[] = $this->getOnclickShowElement($variable . '-row-expanded', ['transition' => 'none']);
        $onclick_show[] = $this->getOnclickHideElement($variable . '*-row-collapsed', ['transition' => 'none']);
        $onclick_show[] = $this->getOnclickHideElement('*-element-on', ['transition' => 'none']);
        $onclick_show[] = $this->getOnclickShowElement($variable . '-element-on');

        $onclick_hide[] = $this->getOnclickHideElement($variable . '-row-expanded', ['transition' => 'none']);
        $onclick_hide[] = $this->getOnclickShowElement($variable . '-row-collapsed', ['transition' => 'none']);
        $onclick_hide[] = $this->getOnclickHideElement($variable . '-element-on');

        if ($variable2) {
            $var2[] = $this->getComponentText($value, ['variable' => $variable], [
                'color' => '#ffffff']);

            if ($var_separator) {
                $var2[] = $this->getComponentText($var_separator, [], [
                    'color' => '#ffffff']);
            }

            $var2[] = $this->getComponentText($value, ['variable' => $parameters['variable2']], [
                'color' => '#ffffff']);

            $col[] = $this->getComponentRow($var2, [], ['floating' => '1', 'float' => 'right']);

        } else {
            $col[] = $this->getComponentText($value, [
                'variable' => $variable
            ], [
                'padding' => '0 15 0 0',
                'floating' => 1,
                'float' => 'right',
                'color' => '#333333' // TODO: check usages accross the other apps
            ]);
        }

        return $this->getComponentColumn([
            $this->getComponentRow($col, [
                'id' => $variable . '-row-collapsed',
                'onclick' => $onclick_show
            ], [
                'vertical-align' => 'middle',
            ]),
            $this->getComponentRow($col, [
                'id' => $variable . '-row-expanded',
                'visibility' => 'hidden',
                'onclick' => $onclick_hide
            ], [
                'vertical-align' => 'middle'
            ]),
            $this->uiKitExpandingFieldField($parameters),
            $this->uiKitDivider()
        ]);
    }

    public function uiKitExpandingFieldField($parameters)
    {
        $title = $this->addParam('title', $parameters, '');
        $value = $this->addParam('value', $parameters, $title);
        $variable = $this->addParam('variable', $parameters, '');
        $icon = $this->addParam('icon', $parameters, false);
        $expanding_content = $this->addParam('expanding_content', $parameters, $this->getComponentText('No content'));

        return $this->getComponentColumn([$expanding_content], [
            'id' => $variable . '-element-on',
            'visibility' => 'hidden'
        ], ['margin' => '0 0 5 0']);
    }

}