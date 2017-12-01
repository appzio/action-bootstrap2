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
        $actionShow[] = $this->getOnclickHideElement("show_" .$item['id']);
        $output[] = $this->getComponentRow(
            $this->getVisibleRow($item['show']),
            array(
                "id" => "show_" .$item['id'],
                "style" => "ui_accordion_line_show_row",
                "onclick" => $actionShow));

        $actionHide[] = $this->getOnclickShowElement("show_" .$item['id']);
        $actionHide[] = $this->getOnclickHideElement("hide_" .$item['id']);
        $actionHide[] = $this->getOnclickHideElement("hidden_" .$item['id']);
        $output[] = $this->getComponentRow(
            $this->getVisibleRow($item['hide'], "ui_accordion_line_hide"),
            array(
                "id" => "hide_" .$item['id'],
                "visibility" => "hidden",
                "style" => "ui_accordion_line_hide_row",
                "onclick" => $actionHide));

        $output[] = $this->getComponentRow(
            $this->getHiddenRow($item['hidden']),
            array("id" => "hidden_" .$item['id'], "visibility" => "hidden", "style" => "ui_accordion_line_hidden_row"));

        return $this->getComponentColumn($output, array("style" => 'ui_accordion_line_container'));
    }

    public function getVisibleRow($item, $stylePrefix = "ui_accordion_line_show") {
        /** @var BootstrapComponent $this */

        $row = [];
        if ($item['icon']) {
            $row[] = $this->getComponentImage($item['icon'], array("style" => $stylePrefix . "_icon"));
        }

        $row[] = $this->getComponentColumn([
            $this->getComponentText($item['title'],array("style" => $stylePrefix . "_title")),
            $this->getComponentText($item['description'],array("style" => $stylePrefix . "_description"))
        ], array(array("style" => $stylePrefix . "_middle_container")));

        if ($item['icon-back']) {
            $row[] = $this->getComponentImage($item['icon-back'],array("style" => $stylePrefix . "_icon-back"));
        }

        return $row;
    }

    public function getHiddenRow($item) {
        /** @var BootstrapComponent $this */

        $row = [];
        if (isset($item['input'])) {
            $row[] = $this->uiKitHintedTextField($item['description'], $item['variable'], $item['input']);
        } else {
            $row[] = $this->getComponentText($item['description'], array("style" => "ui_accordion_hidden_description"));
        }

        if (isset($item['button'])) {
            $row[] = $this->getComponentText($item['button'],
                array('onclick' => $item['action'],"style" => "ui_accordion_hidden_button"));
        }

        return $row;
    }

}