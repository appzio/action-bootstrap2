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
    public function uiKitListItem(string $title, string $date = '', array $parameters=array(), array $styles=array()) {
        /** @var BootstrapView $this */

	    $events = [];
        $title_row[] = $this->getComponentText($title, array(), array(
	        'color' => '#777d81',
	        'font-size' => '16',
        ));

        if ( isset($parameters['onclick']) AND $parameters['onclick'] ) {
        	$events['onclick'] = $parameters['onclick'];
        	$title_row[] = $this->getComponentImage('beak-icon.png', array(), array(
		        'height' => '20',
		        'floating' => '1',
		        'float' => 'right',
	        ));
        }

        $data[] = $this->getComponentRow($title_row, $events, array(
	        'padding' => '0 15 0 15',
	        'vertical-align' => 'middle',
        ));

        if ( $date AND isset($parameters['icon']) ) {
        	$data[] = $this->getComponentRow(array(
        		$this->getComponentImage($parameters['icon'], array(), array(
        			'width' => '25',
        			'margin' => '0 15 0 0',
		        )),
        		$this->getComponentText($date, array(), array(
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