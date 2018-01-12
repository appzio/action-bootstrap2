<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitListItem {

    /**
     * This will return a view with items and provides infinite scrolling. This is compatible with ae_ext_items
     * model and its associated tables. Note that you need to have the paging in place for the controller & model
     * for it to work as expected.
     *
     * @param string $content
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitListItem(string $title, string $discription = '', array $parameters=array(), array $styles=array()) {
        /** @var BootstrapView $this */

	    $events = [];
	    $title_row = [];
	    $text_params = [];

	    if ( isset($parameters['variable']) AND $variable = $parameters['variable'] ) {
	    	$text_params['variable'] = $variable;
		    if ( $value = $this->model->getSubmittedVariableByName( $variable ) ) {
				$text_params['value'] = $value;
				$title = $value;

				if ( isset($parameters['time_format']) AND $parameters['time_format'] AND is_numeric($value) ) {
					$title = date( $parameters['time_format'], $value );
				}

		    }
	    }

	    if ( isset($parameters['left_icon']) AND $parameters['left_icon'] ) {
		    $title_row[] = $this->getComponentImage($parameters['left_icon'], array(), array(
			    'width' => '25',
			    'margin' => '0 10 0 0',
		    ));
	    }

	    $title_row[] = $this->getComponentText($title, $text_params, array(
		    'color' => '#777d81',
		    'font-size' => '16',
	    ));

	    if ( isset($parameters['right_icon']) AND $parameters['right_icon'] ) {
		    $title_row[] = $this->getComponentImage($parameters['right_icon'], array(), array(
			    'height' => '20',
			    'floating' => '1',
			    'float' => 'right',
		    ));
	    }

	    if ( isset($parameters['onclick']) AND $parameters['onclick'] ) {
		    $events['onclick'] = $parameters['onclick'];
	    }

	    $data[] = $this->getComponentRow($title_row, $events, array(
	        'padding' => '0 15 0 15',
	        'vertical-align' => 'middle',
        ));

	    if ( $discription AND isset($parameters['date_icon']) ) {
        	$data[] = $this->getComponentRow(array(
        		$this->getComponentImage($parameters['date_icon'], array(), array(
        			'width' => '25',
        			'margin' => '0 15 0 0',
		        )),
        		$this->getComponentText($discription, array(), array(
        			'color' => '#777d81',
        			'font-size' => '15',
		        )),
	        ), array(), array(
	        	'padding' => '10 15 0 15',
	        	'vertical-align' => 'middle',
	        ));
        }

        if ( isset($parameters['divider']) AND $parameters['divider'] ) {
	        $data[] = $this->getComponentDivider(array(
		        'style' => 'article-uikit-divider'
	        ));
        }

        $behaviour = [];
        $bhv_params = ['id', 'visibility'];

	    foreach ( $bhv_params as $bhv_param ) {
		    if ( isset($parameters[$bhv_param]) ) {
		    	$behaviour[$bhv_param] = $parameters[$bhv_param]; 
		    }
        }

        return $this->getComponentColumn($data, $behaviour, array(
        	'width' => 'auto',
        ));
	}

}