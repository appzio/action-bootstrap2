<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitItemListInfinite {

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

    public function uiKitItemListingInfinite(array $content, array $parameters=array(), array $styles=array()) {
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

	private function getItemBox($item,$parameters){

        $images = json_decode($item->images,true);
        $featured_image = array_shift($images);

        $onclick = new \stdClass();
        $onclick->action = 'open-action';
        $onclick->back_button = 1;
        $onclick->action_config = $this->model->getActionidByPermaname('itemdetail');
        $onclick->sync_open = 1;
        $onclick->id = $item->id;

        $width = ($this->screen_width / 3) - 19;

        $out[] = $this->getComponentImage($featured_image, array(
            'imgwidth' => '200',
            'imgheight' => '200',
            'imgcrop' => 'yes',
            'lazy' => 1,
            'onclick' => $onclick
        ), array(
            'width' => $width,
            'height' => $width,
            'crop' => 'yes'
        ));

        $name = strlen($item->name) > 40 ? substr($item->name,0,40) .'...' : $item->name;
        
        $text[] = $this->getComponentText($name,array(),array(
            'color' => '#545050',
            'font-size' => '13',
            'padding' => '4 4 4 4'));


        $out[] = $this->getComponentRow($text,array(),array(
            'background-color' => '#ffffff',
            'width' => $width,
            'text-align' => 'left',
            'font-size' => '13',
            ));

        $pricerow[] = $this->getComponentText('$'.$item->price,array(),array(
            'color' => '#3EB439',
            'background-color' => '#ffffff',
            'font-size' => '13',
            'padding' => '0 4 4 4'));

        /* setting the item star */
        if(isset($parameters['route_add']) AND $parameters['route_del']){
            $like = $parameters['route_add'].$item->id;
            $unlike = $parameters['route_del'].$item->id;
            $liked = isset($parameters['bookmarks'][$item->id]) ? 1 : 0;
            $star[] = $this->uiKitLikeStar($liked,$like,$unlike,18,$item->id);
            $stars[] = $this->getComponentColumn($star,array(),array('floating' => 1,'float' => 'right','margin' => '0 5 0 0'));
            $pricerow = array_merge($pricerow,$stars);
        }

        $out[] = $this->getComponentRow($pricerow,array(),array(
            'background-color' => '#ffffff',
            'width' => $width,
            'text-align' => 'left',
            'font-size' => '13',
        ));

        $out[] = $this->uikitGetItemTags($item,false,$width);

        return $this->getComponentColumn($out,array(),array(
            'border-radius' => '4',
            'margin' => '0 7 0 7'
        ));


    }

    private function getItemBoxWide($item,$parameters){

        $images = json_decode($item->images,true);
        $featured_image = array_shift($images);

        $onclick = new \stdClass();
        $onclick->action = 'open-action';
        $onclick->back_button = 1;
        $onclick->action_config = $this->model->getActionidByPermaname('itemdetail');
        $onclick->sync_open = 1;
        $onclick->id = $item->id;

        $width = ($this->screen_width / 3)*2 - 23;
        $height = ($this->screen_width / 3) - 19;

        $out[] = $this->getComponentImage($featured_image, array(
            'imgwidth' => '400',
            'imgheight' => '200',
            'imgcrop' => 'yes',
            'lazy' => 1,
            'onclick' => $onclick
        ), array(
            'width' => $width,
            'height' => $height,
            'crop' => 'yes'
        ));

        $text[] = $this->getComponentText($item->name,array(),array(
            'color' => '#545050',
            'font-size' => '13',
            'padding' => '4 4 4 4'));


        $out[] = $this->getComponentRow($text,array(),array(
            'background-color' => '#ffffff',
            'width' => $width,
            'text-align' => 'left',
            'font-size' => '13',
            ));

        $pricerow[] = $this->getComponentText('$'.$item->price,array(),array(
            'color' => '#3EB439',
            'width' => $width,
            'background-color' => '#ffffff',
            'font-size' => '13',
            'padding' => '0 4 4 4'));

        /* setting the item star */
        if(isset($parameters['route_add']) AND $parameters['route_del']){
            $like = $parameters['route_add'].$item->id;
            $unlike = $parameters['route_del'].$item->id;
            $liked = isset($parameters['bookmarks'][$item->id]) ? 1 : 0;
            $star[] = $this->uiKitLikeStar($liked,$like,$unlike,18,$item->id);
            $stars[] = $this->getComponentColumn($star,array(),array('floating' => 1,'float' => 'right','margin' => '0 5 0 0'));
            $pricerow = array_merge($pricerow,$stars);
        }

        $out[] = $this->getComponentRow($pricerow,array(),array(
            'background-color' => '#ffffff',
            'width' => $width,
            'text-align' => 'left',
            'font-size' => '13',
        ));

        $out[] = $this->getComponentText($item->description,array(),array(
            'color' => '#545050',
            'background-color' => '#ffffff',
            'font-size' => '9',
            'width' => $width,
            'height' => '25',
            'padding' => '0 4 0 4'));

        $out[] = $this->uikitGetItemTags($item,true,$width);

        return $this->getComponentColumn($out,array(),array(
            'border-radius' => '4',
            'margin' => '0 7 0 7'
        ));


    }

    private function uikitGetItemTags($item,$wide=false,$width)
    {
        $maxCount = 2;
        $count = 1;
        $tagsList = array();
        $style = array(
            'margin' => '2 2 2 2',
            'font-size' => '9',
            'background-color' => $this->colors['top_bar_color'],
            'color' => $this->colors['top_bar_text_color'],
            'padding' => '4 4 4 4',
            'border-radius' => '3'
        );

        $tag_list = '';

        foreach ($item->tags as $tag) {
            if ($count <= $maxCount) {
                if(strlen($tag->name) > 6){
                    $name = substr($tag->name,0,5) .'...';
                } else {
                    $name = $tag->name;
                }
                $tagsList[] = $this->getComponentText($name, array('style' => 'uikit_item_tag'),$style);
            } else {
                $tagsList[] = $this->getComponentText('...', array('style' => 'uikit_item_tag'),$style);
                break;
            }

            $tag_list .= $tag->name.', ';

            $count++;
        }

        if($tag_list){
            $tag_list = substr($tag_list,'0','-2');
            $out[] = $this->getComponentText('{#tags#}: ',array(),array('font-size' => '9','color' => '#000000'));
            $out[] = $this->getComponentText($tag_list,array(),array('font-size' => '9','color' => '#B2B4B3'));
        } else {
            $out[] = $this->getComponentText('{#no_tags#}',array(),array('font-size' => '9','color' => '#B2B4B3'));
        }

        if($wide){
            return $this->getComponentRow($out, array(), array(
                'padding' => '0 0 4 4',
                'height' => '20',
                'width' => $width,
                'background-color' => '#ffffff',
            ));
        } else {
            return $this->getComponentColumn($out, array(), array(
                'padding' => '0 4 4 4',
                'height' => '45',
                'width' => $width,
                'background-color' => '#ffffff',
            ));
        }


    }

}