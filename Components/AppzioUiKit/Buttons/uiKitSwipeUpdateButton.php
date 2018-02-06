<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitSwipeUpdateButton
{

    public function uiKitSwipeUpdateButton($params = array())
    {
        /** @var BootstrapComponent $this */
        $identifier = $params['identifier'];
        $update_path = 'Allitems/update/' . $identifier;

        if ( isset($params['row_id']) AND $params['row_id'] ) {
        	$identifier = $params['row_id'];
        }

        if ( isset($params['update_path']) AND $params['update_path'] ) {
	        $update_path = $params['update_path'];
        }

        return $this->getComponentRow(array(
            $this->getComponentImage('uikit-icon-task-completed.png', array(
                'style' => 'uikit_swipe_button_image'
            ))
        ), array(
            'style' => 'uikit_swipe_update_button',
            'onclick' => array(
	            $this->getOnclickHideElement('row_' . $identifier),
	            $this->getOnclickSubmit($update_path)
            ),
        ));
    }

}