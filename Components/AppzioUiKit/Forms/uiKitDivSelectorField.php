<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

use Bootstrap\Components\BootstrapComponent as BootstrapComponent;

trait uiKitDivSelectorField
{

    public function uiKitDivSelectorField($parameters = [])
    {
        /** @var BootstrapComponent $this */

        $title = $this->addParam('title', $parameters, '');
        $icon = $this->addParam('icon', $parameters, false);
        $variable = $this->addParam('variable', $parameters, '');
        $div = $this->addParam('div', $parameters, false);

        /*if (isset($this->model->validation_errors[$variable])) {
            $error = $this->model->validation_errors[$variable];
        } elseif (isset($parameters['error']) AND $parameters['error']) {
            $error = $parameters['error'];
        } else {
            $error = false;
        }*/

        return $this->getComponentRow([
            $this->getComponentImage($icon, array('style' => 'uikit-general-field-icon')),
            $this->getComponentText($title, [
                'style' => 'uikit-general-field-text'
            ]),
            $this->getComponentText($this->model->getSavedVariable($variable, ''), [
                'variable' => $variable
            ], [
                'padding' => '0 15 0 0',
                'floating' => 1,
                'float' => 'right',
                'color' => '#333333'
            ]),
        ], [
            'onclick' => $div,
        ], [
            'vertical-align' => 'middle',
        ]);
    }

}