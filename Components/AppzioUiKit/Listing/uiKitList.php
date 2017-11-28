<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitList {

    /**
     * This will return a view with items and provides infinite scrolling. This is compatible with ae_ext_items
     * model and its associated tables. Note that you need to have the paging in place for the controller & model
     * for it to work as expected.
     *
     * @param array $content
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */

    public function uiKitList(array $content, array $parameters=array(), array $styles=array()) {
        /** @var BootstrapView $this */
        $items = array();

        foreach ($content as $item) {
            $items[] = $this->getListRow($item);
            $items[] = $this->getComponentSpacer(1, array(), array(
                'background-color' => '#fafafa'
            ));
        }

        return $this->getComponentColumn($items);
    }

    protected function getListRow($item)
    {
        return $this->getComponentColumn(array(
            $this->getComponentText($item['text'], array(), array(
                'font-size' => 20,
                'font-weight' => 'bold',
                'width' => '200',
                'margin' => '0 0 10 0',
            )),
            $this->getComponentRow(array(
                $this->getComponentText($item['info'], array(), array(
                    'font-size' => '12',
                    'color' => '#9f9f9f',
                )),
                $this->getComponentText($item['additional_info'], array(), array(
                    'font-size' => '12',
                    'color' => '#9f9f9f',
                    'floating' => 1,
                    'float' => 'right'
                ))
            ), array(), array(
                'width' => '180',
            ))
        ), array(), array(
            'padding' => '20 0 20 15',
            'height' => '110'
        ));
    }

}