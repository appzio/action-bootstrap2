<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitItemListPlain {

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

    public function uiKitItemListPlain(array $content, array $parameters=array(), array $styles=array()) {
        /** @var BootstrapView $this */

        $counter = 0;
        $featured_item = array();
        $extra_items = array();
        $featured_counter = 0;

        $page = isset($_REQUEST['next_page_id']) ? $_REQUEST['next_page_id'] : 1;
        $page++;

        foreach($content as $item){

            if(!empty($featured_item) AND $counter < 2){
                $first = array_shift($featured_item);
                $col[] = $this->getItemBoxWide($first,$parameters);
                $col[] = $this->getItemBox($item,$parameters);
                $counter++;
                $counter++;
            } elseif($item->featured AND $counter < 2){
                $col[] = $this->getItemBoxWide($item,$parameters);
                $featured_counter++;
                $counter++;
                $counter++;
            } elseif($item->featured) {
                $featured_item[] = $item;
                continue;
            } else {
                $col[] = $this->getItemBox($item,$parameters);
                $counter++;
            }

            if($counter == 3 AND isset($col)){
                $rows[] = $this->getComponentRow($col,array('style' => 'uikit_itemlist_row'),array('margin' => '15 7 0 7'));
                $counter = 0;
                unset($col);
            }

        }

        if(isset($col)){
            $rows[] = $this->getComponentRow($col,array('style' => 'uikit_itemlist_row'),array('margin' => '15 7 0 7'));
        }

        if(!empty($featured_item)){
            unset($col);
            $first = array_shift($featured_item);
            $col[] = $this->getItemBoxWide($first,$parameters);
            $rows[] = $this->getComponentRow($col,array('style' => 'uikit_itemlist_row'),array('margin' => '15 7 0 7'));
        }


        if(!isset($rows)){
            $rows[] = $this->getComponentText('',array('uikit_search_noresults'));
        }

        if(count($content) < 10){
            return $this->getInfiniteScroll($rows);
        } else {
            return $this->getInfiniteScroll($rows,array('next_page_id' => $page));
        }

	}


}