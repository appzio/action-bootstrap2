<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitSearchItem {

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
    public function uiKitSearchItem (string $icon, string $title, string $side_content = '', array $parameters=array(), array $styles=array()) {
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

	    $title_row[] = $this->getComponentImage($icon, array(), array(
		    'width' => '6%',
		    'margin' => '0 10 0 0',
	    ));

	    $title_row[] = $this->getComponentColumn(array(
		    $this->getComponentText($title, $text_params, array(
			    'color' => '#211d1e',
			    'font-size' => '17',
			    'font-weight' => 'bold',
		    ))
	    ), array(), array(
	    	'width' => ( $side_content ? '50%' : 'auto' ),
	    	'padding' => ( $side_content ? '0 5 0 0' : '0 15 0 0 ' ),
	    ));

	    if ( $side_content ) {
		    $title_row[] = $this->getComponentColumn(array(
			    $this->getComponentText($side_content, $text_params, array(
				    'color' => '#777d81',
				    'font-size' => '12',
				    'text-align' => 'right',
			    )),
		    ), array(), array(
		    	'width' => '35%'
		    ));
	    }

	    if ( isset($parameters['onclick']) AND $parameters['onclick'] ) {
		    $events['onclick'] = $parameters['onclick'];
	    }

	    $data[] = $this->getComponentRow($title_row, $events, array(
		    'width' => 'auto',
	        'padding' => '0 15 0 15',
	        'vertical-align' => 'middle',
        ));

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

        return $this->getComponentColumn($data, $behaviour, array_merge(array(
                'width' => 'auto',
                'padding' => ( isset($parameters['divider']) ? '0 0 0 0' : '10 0 10 0' )
            ),
            $styles
        ));
	}

}