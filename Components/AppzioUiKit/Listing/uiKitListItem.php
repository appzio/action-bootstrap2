<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;
use Bootstrap\Models\BootstrapModel;

trait uiKitListItem {

    /**
     * This component would return a generic and highly customizable listing item.
     * Using the $parameters array you could customize the component in several ways
     * [time_format]
     * Use this if passing a timestamp to the component
     *
     * [left_icon]
     * Define a left image
     *
     * [right_icon]
     * Define a right image ( this is especially useful in case you need to indicate that the item is clickable )
     *
     * [date_icon]
     * If a $description is passed, when set, the "date_icon" image would appear in front if
     *
     * [divider] ( true / false )
     * Visualize a bottom border for the component
     *
     * The component support several controls
     * - "id" - useful in case you would need to hide and show the element in certain cases
     * - "visibility" - hidden / visible
     * - "onclick" - assign a click event for your component
     * - "swipe_right" - add an array items, which would appear as you swipe the component to the right
     *
     * @param string $title
     * @param array $description
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitListItem(string $title, array $description = array(), array $parameters=array(), array $styles=array()) {
        /** @var BootstrapModel $this->model */
        /** @var BootstrapView $this */

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

	    if ( isset($parameters['title']) ) {
	        $title = $parameters['title'];
        }

        if ( isset($parameters['value']) ) {
            $text_params['value'] = $parameters['value'];
        }

	    if ( isset($parameters['left_icon']) AND $parameters['left_icon'] ) {
		    $title_row[] = $this->getComponentImage($parameters['left_icon'], array(), array(
			    'width' => '25',
			    'margin' => '0 10 0 0',
		    ));
	    }

	    $text_styles = array_merge(array(
		    'font-size' => '16',
		    'font-weight' => 'bold',
	    ), $styles);

	    $title_row[] = $this->getComponentText($title, $text_params, $text_styles);

	    if ( isset($parameters['right_icon']) AND $parameters['right_icon'] ) {
		    $title_row[] = $this->getComponentImage($parameters['right_icon'], array(), array(
			    'height' => '20',
			    'floating' => '1',
			    'float' => 'right',
		    ));
	    }

	    $data[] = $this->getComponentRow($title_row, array(), array(
	        'padding' => '0 15 0 15',
	        'vertical-align' => 'middle',
        ));

	    if ( $description AND isset($parameters['date_icon']) ) {
	    	
        	$data[] = $this->getComponentRow(array(
        		$this->getComponentImage($parameters['date_icon'], array(), array(
        			'width' => '25',
        			'margin' => '0 15 0 0',
		        )),
        		$this->getComponentColumn($this->uiKitListDescriptionItems($description), array(), array(
					'width' => 'auto'
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
        $bhv_params = ['id', 'visibility', 'swipe_right', 'onclick'];

	    foreach ( $bhv_params as $bhv_param ) {
		    if ( isset($parameters[$bhv_param]) ) {
		    	$behaviour[$bhv_param] = $parameters[$bhv_param]; 
		    }
        }

        return $this->getComponentColumn($data, $behaviour, array(
        	'width' => 'auto',
        	'padding' => ( isset($parameters['divider']) ? '0 0 0 0' : '10 0 10 0' ),
        ));
	}

	private function uiKitListDescriptionItems( $description ) {

    	$items = [];

		foreach ( $description as $item ) {
			$items[] = $this->getComponentText($item, array(), array(
				'color' => '#9f9f9f',
				'font-size' => '14',
			));
		}

		return $items;
	}

}