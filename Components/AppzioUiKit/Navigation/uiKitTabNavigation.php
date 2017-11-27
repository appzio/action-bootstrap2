<?php

namespace Bootstrap\Components\AppzioUiKit\Navigation;
use Bootstrap\Components\BootstrapComponent;

trait uiKitTabNavigation
{
    public function uiKitTabNavigation($content = array(), $parameters = array(), $styles = array())
    {
        /** @var BootstrapComponent $this */
        $tabs = array();

        foreach ($content as $tab) {
            $tabs[] = $this->getTab($tab);
        }

        return $this->getComponentRow($tabs, array(
            'width' => '100%'
        ));
    }

    protected function getTab($tab)
    {
        /** @var BootstrapComponent $this */

        if (!$tab['active']) {
            return $this->getComponentText($tab['text'], array(
                'onclick' => $tab['onclick'],
            ), array(
                'padding' => '20 0 20 0',
                'text-align' => 'center',
                'background-color' => '#ffffff',
                'border-width' => '1',
                'border-color' => '#fafafa',
                'font-size' => '14',
                'width' => '50%'
            ));
        } else {
            return $this->getComponentColumn(array(
                $this->getComponentText($tab['text'], array(
                    'onclick' => $tab['onclick']
                ), array(
                    'padding' => '20 0 20 0',
                    'text-align' => 'center',
                    'background-color' => '#ffffff',
                    'border-width' => '1',
                    'border-color' => '#fafafa',
                    'font-size' => '14',
                )),
                $this->getComponentSpacer('3', array(), array(
                    'background-color' => "#fecb2f"
                ))
            ), array(), array(
                'width' => '50%'
            ));
        }
    }
}