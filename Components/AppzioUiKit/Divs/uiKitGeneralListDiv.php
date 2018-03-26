<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitGeneralListDiv
{

    public function uiKitGeneralListDiv($params = array())
    {

	    $closeDiv = new \stdClass();
	    $closeDiv->action = 'hide-div';
	    $closeDiv->keep_user_data = 1;

        /** @var BootstrapComponent $this */
        $title = isset($params['title']) ? $params['title'] : '';
        $subtitle = isset($params['subtitle']) ? $params['subtitle'] : '';
        $variable = isset($params['variable']) ? $params['variable'] : 'pick-date';
	    $button_label = isset($params['button_label']) ? $params['button_label'] : '{#select#}';
        $refresh_on_close = isset($params['refresh_on_close']) ? $params['refresh_on_close'] : false;

        if ( !isset($params['data']) OR empty($params['data']) ) {
        	return $this->getComponentText('{#missing_data#}', array(), array(
        		'font-size' => 16,
        		'text-align' => 'center',
	        ));
        }

	    $data = $params['data'];

        return $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentText($title, array(), array(
                    'color' => '#ffffff',
                    'font-size' => '14',
                    'width' => '100%',
                )),
                $this->getComponentImage('uikit-cross-sign.png', array(
                    'onclick' => $closeDiv
                ), array(
                    'width' => '15',
                    'floating' => '1',
                    'float' => 'right',
                    'margin' => '2 0 0 0'
                ))
            ), array(), array(
                'padding' => '10 20 10 20',
                'background-color' => '#4a4a4a',
                'shadow-color' => '#33000000',
                'shadow-radius' => '1',
                'shadow-offset' => '0 3',
                'margin' => '0 0 20 0'
            )),
            $this->getComponentText($subtitle, array(), array(
                'text-align' => 'center',
                'color' => '#797f82',
                'font-size' => '14'
            )),
	        $this->getComponentFormFieldSelectorList($data, array(
		        'value' => ( isset($params['default']) ? $params['default'] : '' ),
		        'variable' => $variable,
		        'update_on_entry' => 1,
	        ), array(
	        	'margin' => '20 0 20 0'
	        )),
	        $this->uiKitWideButton($button_label, array(
		        'onclick' => $this->getCloseButton( $closeDiv, $refresh_on_close )
	        ))
        ), array(), array(
            'background-color' => '#ffffff'
        ));
    }

    private function getCloseButton( $closeDiv, $refresh_on_close ) {

/*        if($select_action){
            $click[] = $this->getOnclickSubmit($select_action);
        }*/

        if ( !$refresh_on_close ) {
            $click = $closeDiv;
            return $click;
        }

        $click[] = $closeDiv;
        $click[] = $this->getOnclickSubmit( 'div-closed' );
        return $click;
    }

}