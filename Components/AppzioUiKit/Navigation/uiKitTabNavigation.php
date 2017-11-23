<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;
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
            'style' => 'uikit_tab_navigation'
        ));
    }

    protected function getTab($tab)
    {
        /** @var BootstrapComponent $this */

        if (!$tab['active']) {
            return $this->getComponentText($tab['text'], array(
                'onclick' => $tab['onclick'],
                'style' => 'uikit_tab_navigation_item'
            ));
        } else {
            return $this->getComponentColumn(array(
                $this->getComponentText($tab['text'], array(
                    'onclick' => $tab['onclick'],
                    'style' => 'uikit_tab_navigation_item'
                )),
                $this->getComponentSpacer('5', array(
                    'style' => 'uikit_tab_navigation_line'
                ))
            ));
        }
    }
}