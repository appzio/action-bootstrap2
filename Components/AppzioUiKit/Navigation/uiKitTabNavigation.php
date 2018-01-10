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
            $tabs[] = $this->getTab($tab, count($content));
        }

        return $this->getComponentRow($tabs, array(
            'width' => '100%'
        ));
    }

    protected function getTab($tab, $count)
    {
        /** @var BootstrapComponent $this */

        if (isset($tab['disabled']) && $tab['disabled']) {
            return $this->getComponentText($tab['text'], array(), array(
                'color' => '#e3e1e1',
                'padding' => '20 0 20 0',
                'text-align' => 'center',
                'background-color' => '#ffffff',
                'border-width' => '1',
                'border-color' => '#fafafa',
                'font-size' => '14',
                'width' => $this->screen_width / $count,
                'font-ios' => 'OpenSans',
                'font-android' => 'OpenSans'
            ));
        } else if (!$tab['active']) {
            return $this->getComponentText($tab['text'], array(
                'onclick' => $tab['onclick'],
            ), array(
                'color' => '#323232',
                'padding' => '20 0 20 0',
                'text-align' => 'center',
                'background-color' => '#ffffff',
                'border-width' => '1',
                'border-color' => '#fafafa',
                'font-size' => '14',
                'width' => $this->screen_width / $count,
                'font-ios' => 'OpenSans',
                'font-android' => 'OpenSans'
            ));
        } else {
            return $this->getComponentColumn(array(
                $this->getComponentText($tab['text'], array(
                    'onclick' => $tab['onclick']
                ), array(
                    'padding' => '20 0 17 0',
                    'text-align' => 'center',
                    'background-color' => '#ffffff',
                    'border-width' => '1',
                    'border-color' => '#fafafa',
                    'font-size' => '14',
                    'font-ios' => 'OpenSans',
                    'font-android' => 'OpenSans',
                )),
                $this->getComponentSpacer('3', array(), array(
                    'background-color' => "#fecb2f"
                ))
            ), array(), array(
                'width' => $this->screen_width / $count,
            ));
        }
    }
}