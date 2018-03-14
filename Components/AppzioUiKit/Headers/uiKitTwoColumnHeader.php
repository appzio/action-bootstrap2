<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitTwoColumnHeader {


    /**
     * Renders uikit header with a text on the left and any
     * @param string $text
     * @param object $column2
     * Insert any object here (for example getText)
     * @return mixed
     */

    public function uiKitTwoColumnHeader(string $text, $column2 = false, $parameters = array(), $styles = array()){

        $row[] = $this->getComponentText($text,array(),array(
            'font-size' => '12',
        ));

        if ( $column2 ) {

            $row[] = $this->getComponentColumn(array($column2),array(),array(
                'margin' => '0 0 0 0',
                'text-align' => 'right',
                'floating' => 1,
                'float' => 'right'
            ));

        }

        $output[] = $this->getComponentRow($row,array(),array(
            'padding' => '8 15 8 15',
            'background-color' => '#F6F6F6',
        ));

        $output[] = $this->uiKitDivider();
        return $this->getComponentColumn($output, $parameters, array_merge(
            array(
                'vertical-align' => 'middle',
            ),
            $styles
        ));
    }

}