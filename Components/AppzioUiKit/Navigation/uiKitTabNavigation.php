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
            $tabs[] = $this->getTab($tab, count($content), $styles);
        }

        return $this->getComponentRow($tabs, $parameters, array(
            'width' => '100%'
        ));
    }

    protected function getTab($tab, $count, $styles)
    {
        /** @var BootstrapComponent $this */

        $text = $tab['text'];
        $onclick = $tab['onclick'];
        $width = $this->screen_width / $count;

        if (isset($tab['disabled']) && $tab['disabled']) {

            return $this->getDisabledTab($text, $width, $styles);

        } else if (!$tab['active']) {

            return $this->getNormalTab($text, $width, $onclick, $styles);

        } else {
            return $this->getActiveTab($text, $width, $styles);

        }
    }

    protected function getDisabledTab($text, $width, $styles)
    {
        $tab_styles = $this->uiKitTabStyles($styles, array(
            'font-size',
            'text-align'
        ), array(
            'color' => '#e3e1e1',
            'padding' => '20 0 20 0',
            'text-align' => 'center',
            'background-color' => '#ffffff',
            'border-width' => '1',
            'border-color' => '#fafafa',
            'font-size' => '14',
            'width' => $width,
        ));

        return $this->getComponentText($text, array(),$tab_styles);
    }

    protected function getActiveTab($text, $width, $styles)
    {
        
        if ( isset($styles['active_marker']) ) {
            $active_marker = $styles['active_marker'];
        } else {
            $active_marker = 'bottom';
        }

        $tab_styles = $this->uiKitTabStyles($styles, array(
            'font-size',
            'text-align',
        ), array(
            'padding' => '23 0 20 0',
            'height' => 'auto',
            'text-align' => 'center',
            'background-color' => '#ffffff',
            'border-width' => '1',
            'border-color' => '#fafafa',
            'font-size' => '14',
        ));

        return $this->getComponentColumn(array(
            $this->getComponentText($text, array(), $tab_styles),
            $this->getComponentSpacer('3', array(), array(
                'background-color' => $this->color_top_bar_color,
                'vertical-align' => $active_marker
            )),
        ), array(), array(
            'width' => $width,
        ));
    }

    protected function getNormalTab($text, $width, $onclick, $styles)
    {

        $tab_styles = $this->uiKitTabStyles($styles, array(
            'font-size',
            'text-align'
        ), array(
            'color' => '#323232',
            'padding' => '20 0 20 0',
            'text-align' => 'center',
            'background-color' => '#ffffff',
            'border-width' => '1',
            'border-color' => '#fafafa',
            'font-size' => '14',
            'width' => $width,
        ));

        return $this->getComponentText($text, array(
            'onclick' => $onclick
        ), $tab_styles);
    }

    protected function uiKitTabStyles( $styles, array $allowed, array $default = array() ) {

        $allowed_styles = [];

        foreach ($allowed as $item) {

            foreach ($styles as $style_key => $style_value) {
                if ( $item === $style_key ) {
                    $allowed_styles[$style_key] = $style_value;
                }
            }

        }

        return array_merge($default, $allowed_styles);
    }

}