<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitSwipeDeleteButton
{
    public $isLiked;

    public function uiKitSwipeDeleteButton($params = array())
    {
        /** @var BootstrapComponent $this */
        $identifier = $params['identifier'];
        $delete_path = 'Controller/delete/' . $identifier;

        if ( isset($params['delete_path']) AND $params['delete_path'] ) {
        	$delete_path = $params['delete_path'];
        }

        return $this->getComponentRow(array(
            $this->getComponentImage('icons8-trash.png', array(
                'style' => 'uikit_swipe_delete_button_image'
            ))
        ), array(
            'style' => 'uikit_swipe_delete_button',
            'onclick' => array(
                $this->getOnclickHideElement('row_' . $identifier),
                $this->getOnclickSubmit($delete_path)
            )
        ));
    }

}