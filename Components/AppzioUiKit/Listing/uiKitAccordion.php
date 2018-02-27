<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

use Bootstrap\Components\BootstrapComponent;

trait uiKitAccordion
{

    /**
     * @param array $items
     * array(
     *      0 => array (
     *          'id' => optional,
     *          'expanded' => 'should this item be expanded in advance' - optional - false by default
     *          'show' => array (
     *              'icon' => 'name of image' - optional,
     *              'title' => 'string',
     *              'description' => 'string',
     *              'icon-back' => 'name of image' - optional
     *          ),
     *          'hide' => array (
     *              'icon' => 'name of image' - optional,
     *              'title' => 'string',
     *              'description' => 'string',
     *              'icon-back' => 'name of image' - optional
     *          ),
     *          'hidden' => array(
     *              'input' => 'input type' - optional,
     *              'variable' => 'name of the input variable' - required if input is set,
     *              'description' => 'string' - hint for input or text,
     *              'button' => 'the text of the button' - optional,
     *              'action' => 'the button event' - required if button is set
     *          )
     *      )
     * )
     * @param array $params
     * @return \stdClass
     */
    public function uiKitAccordion(array $items, array $params = array())
    {

        /** @var BootstrapComponent $this */
        
        $stack = array();

        foreach ($items as $key => $item) {

            if (!isset($item['id'])) {
                $item['id'] = 'line_'.$key;
            }
            $stack[] = $this->uiKitAccordionItem($item);
            $stack[] = $this->getComponentSpacer('1', array(), array(
                'background-color' => '#dadada',
                'opacity' => '0.5'
            ));
        }

        if ($stack) {
            return $this->getComponentColumn($stack);
        }

        return $this->getComponentText('no items');
    }

    public function uiKitAccordionItem($item)
    {
        /** @var BootstrapComponent $this */

        $actionShow[] = $this->getOnclickShowElement("hide_" .$item['id']);
        $actionShow[] = $this->getOnclickShowElement("hidden_" .$item['id']);
        $actionShow[] = $this->getOnclickHideElement("show_" .$item['id'], array(
            'transition' => 'none'
        ));
        $actionShow[] = $this->getOnclickHideElement("hidden_arrow_" .$item['id'], array(
            'transition' => 'none'
        ));

        $actionHide[] = $this->getOnclickShowElement("show_" .$item['id']);
        $actionHide[] = $this->getOnclickShowElement("hidden_arrow_" .$item['id']);
        $actionHide[] = $this->getOnclickHideElement("hide_" .$item['id'], array(
            'transition' => 'none'
        ));
        $actionHide[] = $this->getOnclickHideElement("hidden_" .$item['id'], array(
            'transition' => 'none'
        ));

        $item['show']['id'] = $item['id'];
        $item['show']['expanded'] = ( isset($item['show']['description']) AND $item['show']['description'] AND isset($item['expanded']) ) ? true : false;

        $output[] = $this->getComponentRow($this->getVisibleRow($item['show']), array(
            "id" => "show_" .$item['id'],
            "style" => "ui_accordion_line_show_row",
            "onclick" => $actionShow
        ));

        $output[] = $this->getComponentRow($this->getVisibleRow($item['hide'], "ui_accordion_line_hide"), array(
            "id" => "hide_" .$item['id'],
            "visibility" => 'hidden',
            "style" => "ui_accordion_line_hide_row",
            "onclick" => $actionHide
        ));

        $output[] = $this->getComponentRow($this->getHiddenRow($item['hidden']), array(
            "id" => "hidden_" .$item['id'],
            "visibility" => isset($item['expanded']) ? '' : 'hidden',
            "style" => "ui_accordion_line_hidden_row"
        ));

        return $this->getComponentColumn($output, array("style" => 'ui_accordion_line_container'));
    }

    public function getVisibleRow($item, $stylePrefix = "ui_accordion_line_show") {
        /** @var BootstrapComponent $this */

        $row = [];
        if ($item['icon']) {
            // $row[] = $this->getComponentImage($item['icon'], array("style" => $stylePrefix . "_icon"));
            $row[] = $this->getComponentColumn(array(
                $this->getComponentImage($item['icon'], array(), array(
                    'width' => '100%',
                ))
            ), array(), array(
                'width' => 100,
                'padding' => '5 0 0 0',
                'vertical-align' => 'top',
            ));
        }

        $content = [];

        if ( isset($item['title']) AND $item['title'] ) {
            $content[] = $this->getComponentText($item['title'],array("style" => $stylePrefix . "_title"));
        }

        if ( isset($item['description']) AND $item['description'] ) {
            $content[] = $this->getComponentColumn($item['description'], array(), array(
                'padding' => '0 0 0 0',
                'height' => '150'
            ));
        }

        if ($stylePrefix == 'ui_accordion_line_show') {
            $content[] = $this->getComponentRow(array(
                $this->getComponentImage('arrow_pd.png', array(), array(
                    'width' => '20'
                ))
            ), array(
                "id" => "hidden_arrow_" . $item['id'],
                "visibility" => (isset($item['expanded']) AND $item['expanded']) ? 'hidden' : '',
            ), array(
                'width' => 'auto',
                'text-align' => 'right',
                'margin' => '0 20 20 0'
            ));
        }

        $row[] = $this->getComponentColumn($content, array(
            "style" => $stylePrefix . "_middle_container"
        ), array());

//        if ($item['icon-back']) {
//            $row[] = $this->getComponentImage($item['icon-back'],array("style" => $stylePrefix . "_icon-back"));
//        }

        return $row;
    }

    public function getHiddenRow($item) {
        /** @var BootstrapComponent $this */
        $row = [];

        if (isset($item['input'])) {
            $input = isset($item['value']) ? $item['value'] : '';

            $row[] = $this->getComponentFormFieldTextArea($input, array(
                'hint' => 'Enter text here',
                'variable' => $item['variable']
            ), array(
                'padding' => '8 10 8 10',
                'border-width' => '1',
                'border-color' => '#cccccc',
            ));
        } else {
            $row[] = $this->getComponentText($item['description'], array(), array(
                'width' => 'auto',
                'padding' => '8 10 8 10',
                'border-width' => '1',
                'border-color' => '#cccccc',
            ));
        }

        if (isset($item['button'])) {
            $row[] = $this->getComponentText($item['button'],
                array('onclick' => $item['action'],"style" => "ui_accordion_hidden_button"));
        }

        return $row;
    }

}