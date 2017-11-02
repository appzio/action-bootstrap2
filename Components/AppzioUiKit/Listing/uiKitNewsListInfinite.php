<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitNewsListInfinite {

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

    public function uiKitNewsListingInfinite(array $content, array $parameters=array(), array $styles=array()) {
        /** @var BootstrapView $this */

	    $rows = array();
	    $is_scrollable = false;
	    $next_page_id = 1;

	    if ( count($content) > 10 ) {
		    $chunks = array_chunk( $content, 10, true );

		    if ( isset($_REQUEST['next_page_id']) ) {
			    $next_page_id = $_REQUEST['next_page_id'] + 1;
		    }

		    $data = ( isset($chunks[$next_page_id-1]) ? $chunks[$next_page_id-1] : array() );
		    $is_scrollable = true;
	    } else {
		    $data = $content;
	    }
        
        foreach($data as $item){

	        $rows[] = $this->getComponentRow(array(
				$this->getNewsItemBox( $item, $parameters )
	        ), array(
	        	'style' => 'uikit_itemlist_row'
	        ), array(
	        	'margin' => '15 7 0 7'
	        ));

        }

        if ( $is_scrollable ) {

        	if ( empty($rows) ) {
                $rows[] = $this->getComponentText('{#no_more_results#}', array(
                	'style' => 'uikit_search_noresults'
                ));
		        $next_page_id--;
	        }

	        return $this->getInfiniteScroll($rows,array('next_page_id' => $next_page_id));
        } else {
        	return $this->getComponentColumn($rows, array(), array(
        		'margin' => '0 0 15 0'
	        ));
        }

	}

    private function getNewsItemBox($item, $parameters){

        $width = '100%';
        $height = ($this->screen_width / 3);

        $out[] = $this->getComponentImage($item->photo, array(
            'imgwidth' => '900',
            'imgheight' => '400',
            'imgcrop' => 'yes',
            'lazy' => 1,
            'onclick' => $this->getOnclickOpenUrl( $item->link_url ),
        ), array(
            'width' => $width,
            'height' => $height,
            'crop' => 'yes',
        ));

        $text[] = $this->getComponentText($item->name,array(),array(
            'color' => '#545050',
            'font-size' => '20',
            'font-weight' => 'bold',
            'padding' => '5 5 5 5'));

        $out[] = $this->getComponentRow($text,array(),array(
            'background-color' => '#ffffff',
            'width' => $width,
            'text-align' => 'left',
            'font-size' => '13',
        ));

        $place_info = $this->getRelatedPlace( $item->club_id );
        if ( $place_info ) {
        	$out[] = $this->getPlaceInfo( $place_info, $item );
        }

        $out[] = $this->getComponentText('View news', array(
	        'onclick' => $this->getOnclickShowElement('news_item_' . $item->id)
        ), array(
			'color' => '#545050',
			'font-size' => '15',
			'padding' => '7 5 7 5'
        ));

        $out[] = $this->getComponentColumn(array(
	        $this->getComponentText($item->description, array(), array(
		        'color' => '#545050',
		        'font-size' => '12',
		        'padding' => '7 5 7 5'
	        )),
	        $this->getComponentText('Hide news', array(
		        'onclick' => $this->getOnclickHideElement('news_item_' . $item->id)
	        ), array(
		        'color' => '#545050',
		        'font-size' => '15',
		        'padding' => '0 5 7 5'
	        )),
        ),array(
	        'id' => 'news_item_' . $item->id,
	        'visibility' => 'hidden',
        ),array(
        ));

        return $this->getComponentColumn($out,array(),array(
            'border-radius' => '4',
            'margin' => '0 7 0 7',
            'background-color' => '#ffffff',
        ));

    }

    private function getRelatedPlace( $place_id ) {

	    \Yii::import('application.modules.aelogic.packages.actionMobileplaces.models.*');

	    $clubs = new \MobileplacesModel();
	    $current_club = $clubs->findByPk( $place_id );

	    if ( empty($current_club) ) {
	    	return false;
	    }

	    return $current_club;
    }

    private function getPlaceInfo( $place_info, $item ) {
	    return $this->getComponentRow(array(
		    $this->getComponentImage($place_info->logo, array(), array(
			    'width' => 20,
			    'height' => 20,
			    'crop' => 'round',
			    'margin' => '0 5 0 0'
		    )),
		    $this->getComponentText($place_info->name, array(), array(
			    'font-size' => '16',
			    'color' => '#2badd7',
		    )),
		    $this->getComponentText('•', array(), array(
			    'font-size' => '10',
			    'color' => '#b3b3b3',
			    'padding' => '0 5 0 5'
		    )),
		    $this->getComponentText($this->convertTime($item->timestamp), array(), array(
			    'font-size' => '14',
			    'color' => '#b3b3b3',
		    )),
	    ), array(), array(
		    'vertical-align' => 'middle',
		    'padding' => '0 5 0 5',
	    ));
    }

	private function convertTime($datetime, $full = false) {
		$now = new \DateTime;
		$ago = new \DateTime($datetime);
		$diff = $now->diff($ago);

		$diff->w = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$string = array(
			'y' => 'year',
			'm' => 'month',
			'w' => 'week',
			'd' => 'day',
			'h' => 'hour',
			'i' => 'minute',
			's' => 'second',
		);

		foreach ($string as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
			} else {
				unset($string[$k]);
			}
		}

		if (!$full) $string = array_slice($string, 0, 1);
		return $string ? implode(', ', $string) . ' ago' : 'just now';
	}

}