<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitIconList
{
    /**
     * @param array $content
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitIconList(array $content, array $parameters = array(), array $styles = array())
    {
        /** @var BootstrapView $this */
        $items = array();

        foreach ($content as $item) {
            $items[] = $this->getItemRow($item);
            $items[] = $this->getComponentSpacer(1, array(), array(
                'background-color' => '#fafafa'
            ));
        }

        return $this->getComponentColumn($items);
    }

    protected function getItemRow($item)
    {
        /** @var BootstrapView $this */
        return $this->getComponentRow(array(
            $this->getComponentImage($item['icon'], array(), array(
                'width' => 15,
                'margin' => '0 10 0 10'
            )),
            $this->getComponentText($item['title'], array(), array(
                'color' => '#000000',
                'font-size' => 22,
                'font-weight' => 'bold',
                'width' => '200'
            )),
            $this->getComponentText($item['subtitle'], array(), array(
                'color' => '#dfdfdf',
                'floating' => 1,
                'float' => 'right',
                'margin' => '0 10 0 0',
                'font-size' => 12
            ))
        ), array(), array(
            'vertical-align' => 'middle',
            'padding' => '20 0 20 0'
        ));
    }
}