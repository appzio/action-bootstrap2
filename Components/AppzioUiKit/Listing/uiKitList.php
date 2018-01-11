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
            $items[] = $this->uiKitDivider();
        }

        return $this->getComponentColumn($items);
    }

    protected function getListRow($item)
    {
        /** @var BootstrapView $this */

        $onclick = new \stdClass();
        $onclick->id = $item['id'];
        $onclick->action = 'open-action';
        $onclick->action_config = $this->model->getActionidByPermaname('viewvisit');
        $onclick->back_button = 1;
        $onclick->sync_open = true;

        return $this->getComponentColumn(array(
            $this->getComponentText($item['text'], array(), array(
                'font-size' => 16,
                'font-weight' => 'bold',
                'width' => '200',
                'margin' => '0 0 10 0',
                'font-ios' => 'OpenSans',
                'font-android' => 'OpenSans'
            )),
            $this->getComponentRow(array(
                $this->getComponentText($item['info'], array(), array(
                    'font-size' => '11',
                    'color' => '#9f9f9f',
                    'font-ios' => 'OpenSans',
                    'font-android' => 'OpenSans'
                )),
                $this->getComponentText($item['additional_info'], array(), array(
                    'font-size' => '11',
                    'color' => '#9f9f9f',
                    'floating' => 1,
                    'float' => 'right',
                    'font-ios' => 'OpenSans',
                    'font-android' => 'OpenSans'
                ))
            ), array(), array(
                'width' => '180',
            ))
        ), array(
            'id' => 'row_' . $item['id'],
            'swipe_right' => array(
                $this->getComponentRow(array(
                    $this->getComponentImage('icons8-trash.png', array(), array(
                        'width' => '30'
                    ))
                ), array(
                    'onclick' => array(
                        $this->getOnclickHideElement('row_' . $item['id']),
                        $this->getOnclickSubmit('Controller/delete/' . $item['id'])
                    )
                ), array(
                    'padding' => '0 20 0 20',
                    'background-color' => '#fc4944',
                    'vertical-align' => 'middle'
                ))
            ),
            'onclick' => $onclick
        ), array(
            'padding' => '20 0 20 15',
            'height' => 100,
            'width' => '100%'
        ));
    }

}