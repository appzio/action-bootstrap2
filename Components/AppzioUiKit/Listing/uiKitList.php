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
     * [id]
     * Some sort of identifier; Used for the list item animations on delete.
     *
     * [text]
     * The main text in the list item.
     *
     * [info]
     * Information displayed underneath the main text.
     *
     * [additional_info]
     * Additional info which is displayed on the second row next to the info text.
     *
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

        if ( !isset($item['text']) ) {
	        return $this->getComponentColumn(array(
		        $this->getComponentText('{#missing_text_item#}', array(
			        'style' => 'uikit_list_row_text'
		        )),
	        ), array(
		        'style' => 'uikit_list_row'
	        ));
        }

        $onclick = new \stdClass();
        $onclick->id = $item['id'];
        $onclick->action = 'open-action';
        $onclick->action_config = $this->model->getActionidByPermaname('viewvisit');
        $onclick->back_button = 1;
        $onclick->sync_open = true;

        return $this->getComponentColumn(array(
            $this->getComponentText($item['text'], array(
                'style' => 'uikit_list_row_text'
            )),
            $this->getListRowSecondary($item)
        ), array(
            'id' => 'row_' . $item['id'],
            'swipe_right' => array(
                $this->uiKitSwipeDeleteButton(array('identifier' => $item['id']))
            ),
            'onclick' => $onclick,
            'style' => 'uikit_list_row'
        ));
    }

    protected function getListRowSecondary($item)
    {
        return $this->getComponentRow(array(
            $this->getComponentText($item['info'], array(
                'style' => 'uikit_list_row_info'
            )),
            $this->getComponentText($item['additional_info'], array(
                'style' => 'uikit_list_row_additional_info'
            ))
        ), array(
            'style' => 'uikit_list_row_info_wrapper'
        ));
    }

}