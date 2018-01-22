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

        $text = $tab['text'];
        $onclick = $tab['onclick'];
        $width = $this->screen_width / $count;

        if (isset($tab['disabled']) && $tab['disabled']) {

            return $this->getDisabledTab($text, $width);

        } else if (!$tab['active']) {

            return $this->getSelectedTab($text, $width);

        } else {

            return $this->getActiveTab($text, $width, $onclick);

        }
    }

    protected function getDisabledTab($text, $width)
    {
        return $this->getComponentText($text, array(), array(
            'color' => '#e3e1e1',
            'padding' => '20 0 20 0',
            'text-align' => 'center',
            'background-color' => '#ffffff',
            'border-width' => '1',
            'border-color' => '#fafafa',
            'font-size' => '14',
            'width' => $width,
        ));
    }

    protected function getActiveTab($text, $width, $onclick)
    {
        return $this->getComponentColumn(array(
            $this->getComponentText($text, array(
                'onclick' => $onclick
            ), array(
                'padding' => '20 0 17 0',
                'text-align' => 'center',
                'background-color' => '#ffffff',
                'border-width' => '1',
                'border-color' => '#fafafa',
                'font-size' => '14',
            )),
            $this->getComponentSpacer('3', array(), array(
                'background-color' => "#FFCC00"
            ))
        ), array(), array(
            'width' => $width,
        ));
    }

    protected function getSelectedTab($text, $width)
    {
        return $this->getComponentText($text, array(), array(
            'color' => '#323232',
            'padding' => '20 0 20 0',
            'text-align' => 'center',
            'background-color' => '#ffffff',
            'border-width' => '1',
            'border-color' => '#fafafa',
            'font-size' => '14',
            'width' => $width,
        ));
    }
}