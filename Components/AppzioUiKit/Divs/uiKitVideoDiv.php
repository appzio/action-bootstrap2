<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitVideoDiv
{
    public function uiKitVideoDiv($params = array(), $styles = array())
    {
        /** @var BootstrapComponent $this */
	    $closeDiv = new \stdClass();
	    $closeDiv->action = 'hide-div';
	    $closeDiv->keep_user_data = 1;

	    /** @var BootstrapComponent $this */
	    $title = isset($params['title']) ? $params['title'] : 'Video';
	    $div_id = isset($params['div_id']) ? $params['div_id'] : '';

	    return $this->getComponentColumn(array(
		    $this->getComponentRow(array(
			    $this->getComponentText($title, array(), array(
				    'color' => '#ffffff',
				    'font-size' => '14',
				    'width' => '100%',
			    )),
                $this->getComponentImage('cross-sign.png', array(), array(
                    'width' => '15',
                    'floating' => '1',
                    'float' => 'right',
                    'margin' => '2 0 0 0'
                )),
		    ), array(
                'onclick' => $this->getOnclickHideDiv($div_id)
            ), array(
			    'padding' => '10 20 10 20',
			    'background-color' => '#4a4a4a',
			    'shadow-color' => '#33000000',
			    'shadow-radius' => '1',
			    'shadow-offset' => '0 3',
			    'margin' => '0 0 0 0'
		    )),
			$this->getComponentVideo($params['video_url'], array(
				'showplayer' => 1,
				'autostart' => 1,
			), array(
				'margin' => '0 0 100 0'
			)),
		    $this->getComponentRow(array(
			    $this->getComponentText('{#close#}', array('style' => 'uikit_wide_button_text'))
		    ), array(
			    'onclick' => $closeDiv,
		    ), array(
			    'width' => '75%',
			    'text-align' => 'center',
			    'vertical-align' => 'bottom',
			    'margin' => '0 0 15 0',
			    'floating' => '1',
		    )),
	    ), array(), array(
		    'background-color' => '#ffffff'
	    ));
    }

}