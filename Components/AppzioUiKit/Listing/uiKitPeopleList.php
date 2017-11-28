<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitPeopleList
{
    /**
     * @param array $content
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitPeopleList(array $content, array $parameters = array(), array $styles = array())
    {
        /** @var BootstrapView $this */
        $items = array();

        foreach ($content as $item) {
            $items[] = $this->getPersonRow($item);
            $items[] = $this->getComponentSpacer(1, array(), array(
                'background-color' => '#fafafa'
            ));
        }

        return $this->getComponentColumn($items);
    }

    protected function getPersonRow($person)
    {
        /** @var BootstrapView $this */
        return $this->getComponentRow(array(
            $this->getComponentImage($person['image'], array(), array(
                'width' => '45',
                'crop' => 'yes',
                'imgcrop' => 'round',
                'margin' => '0 10 0 10',
            )),
            $this->getComponentColumn(array(
                $this->getComponentText($person['name'], array(), array(
                    'padding' => '0 0 0 0',
                    'font-weight' => 'bold'
                )),
                $this->getComponentText($person['info'], array(), array(
                    'padding' => '0 0 0 0',
                    'color' => '#a8a8a8',
                    'font-size' => '14'
                )),
                $this->getComponentText($person['contact'], array(), array(
                    'padding' => '0 0 0 0',
                    'color' => '#a8a8a8',
                    'font-size' => '14'
                ))
            ))
        ), array(
            'onclick' => $person['onclick']
        ), array(
            'vertical-align' => 'middle',
            'padding' => '15 0 15 0'
        ));
    }
}