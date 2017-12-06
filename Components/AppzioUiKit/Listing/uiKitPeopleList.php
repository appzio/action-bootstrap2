<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitPeopleList
{
    /**
     * @param array $people
     * array(
     *     0 => array(
     *         'name' - the name of the person - required,
     *         'info' - additional information - required,
     *         'contact' - contact information for the person - required,
     *         'onclick' - action to be executed on row click - required
     *     )
     * )
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitPeopleList(array $people, array $parameters = array(), array $styles = array())
    {
        /** @var BootstrapView $this */
        $items = array();

        foreach ($people as $item) {
            $items[] = $this->getPersonRow($item);
            $items[] = $this->getComponentSpacer(1, array(), array(
                'background-color' => '#fafafa'
            ));
        }

        return $this->getComponentColumn($items);
    }

    protected function getPersonRow($person)
    {
        $divLayout = new \stdClass();
        $divLayout->top = 80;
        $divLayout->bottom = 0;
        $divLayout->left = 0;
        $divLayout->right = 0;

        /** @var BootstrapView $this */
        return $this->getComponentRow(array(
            $this->getComponentColumn(array(
                $this->getComponentText($person['name'], array(), array(
                    'padding' => '0 0 0 0',
                    'font-ios' => 'OpenSans',
                    'font-size' => '14'
                )),
                $this->getComponentText(strtoupper($person['info']), array(), array(
                    'padding' => '0 0 0 0',
                    'color' => '#a8a8a8',
                    'font-size' => '12',
                    'font-ios' => 'OpenSans'
                )),
                $this->getComponentText($person['contact'], array(), array(
                    'padding' => '0 0 0 0',
                    'color' => '#a8a8a8',
                    'font-size' => '12',
                    'font-ios' => 'OpenSans'
                ))
            ))
        ), array(
            'onclick' => $this->getOnclickShowDiv('email', array(
                'background' => 'blur',
                'tap_to_close' => 1,
                'transition' => 'from-bottom',
                'layout' => $divLayout
            ))
        ), array(
            'vertical-align' => 'middle',
            'padding' => '10 0 10 20',
        ));
    }
}