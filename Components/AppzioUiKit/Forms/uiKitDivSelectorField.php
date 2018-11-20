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

        $value = $this->model->getSavedVariable(
            $variable,
            $this->model->getSubmittedVariableByName($variable)
        );

        return $this->getComponentRow([
            $this->getComponentImage($icon, array('style' => 'uikit-general-field-icon')),
            $this->getComponentText($title, [
                'style' => 'uikit-general-field-text'
            ]),
            $this->getComponentText($value, [
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