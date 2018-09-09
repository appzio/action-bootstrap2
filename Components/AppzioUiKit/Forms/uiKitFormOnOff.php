<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Components\BootstrapComponent as BootstrapComponent;

trait uiKitFormOnOff {

    public function uiKitFormOnOff(array $parameters=array()){
        /** @var BootstrapComponent $this */

        $title = $this->addParam('title', $parameters,'');
        $value = $this->addParam('value', $parameters,'');
        $variable = $this->addParam('variable', $parameters,'');

        return $this->getComponentRow(array(
            $this->getComponentText($title, array(
            ),['margin' => '4 15 4 15','width' => '70%','font-size' => '14']),
            $this->getComponentFormFieldOnoff(array(
                'type' => 'toggle',
                'variable' => $variable,
                'value' => $value
            ),['margin' => '4 15 4 15'])
        ),['width' => '90%']);

    }

}