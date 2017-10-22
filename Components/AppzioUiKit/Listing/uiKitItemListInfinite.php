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

        foreach($content as $item){
            $col[] = $this->getItemBox($item,$parameters);
            $counter++;

            if($counter == 3){
                $rows[] = $this->getComponentRow($col,array('style' => 'uikit_itemlist_row'),array('margin' => '15 7 0 7'));
                $counter = 0;
                unset($col);
            }
        }

        if(isset($col)){
            $rows[] = $this->getComponentColumn($col);
        }

        return $this->getInfiniteScroll($rows,array('next_page_id' => '2'));
	}

	private function getItemBox($item,$parameters){

        $images = json_decode($item->images,true);
        $featured_image = array_shift($images);

        $onclick = new \stdClass();
        $onclick->action = 'open-action';
        $onclick->back_button = 1;
        $onclick->action_config = $this->model->getActionidByPermaname('itemdetail');
        $onclick->sync_open = 1;
        $onclick->sync_close = 1;
        $onclick->id = $item->id;

        $width = ($this->screen_width / 3) - 19;

        $out[] = $this->getComponentImage($featured_image, array(
            'imgwidth' => '200',
            'imgheight' => '200',
            'imgcrop' => 'yes',
            'onclick' => $onclick
        ), array(
            'width' => $width,
            'height' => $width,
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
            'background-color' => '#ffffff',
            'font-size' => '13',
            'padding' => '0 4 4 4'));

        if(isset($parameters['route_add']) AND $parameters['route_del']){
            $stars = $this->getStars($parameters,$item);
            $pricerow = array_merge($pricerow,$stars);
        }

        $out[] = $this->getComponentRow($pricerow,array(),array(
            'background-color' => '#ffffff',
            'width' => $width,
            'text-align' => 'left',
            'font-size' => '13',
        ));

        $out[] = $this->uikitGetItemTags($item);

        return $this->getComponentColumn($out,array(),array(
            'border-radius' => '4',
            'margin' => '0 7 0 7'
        ));


    }

    private function getStars($parameters,$item){
        $style = array(
            'floating' => '1',
            'float' => 'right',
            'height' => 18,
            'margin' => '0 5 0 0',
        );

        $onclick_hide[] = $this->getOnclickShowElement('hidden_'.$item->id,array('transition' => 'none'));
        $onclick_hide[] = $this->getOnclickHideElement('visible_'.$item->id,array('transition' => 'none'));

        $onclick_show[] = $this->getOnclickHideElement('hidden_'.$item->id,array('transition' => 'none'));
        $onclick_show[] = $this->getOnclickShowElement('visible_'.$item->id,array('transition' => 'none'));

        /* if is active */
        if(isset($parameters['bookmarks'][$item->id])){
            $onclick_hide[] = $this->getOnclickSubmit($parameters['route_del'].$item->id);

            $pricerow[] = $this->getComponentImage('star_selected.png',array(
                'onclick' => $onclick_hide,
                'id' => 'visible_'.$item->id
            ),$style);

            $onclick_hide[] = $this->getOnclickSubmit($parameters['route_add'].$item->id);

            $pricerow[] = $this->getComponentImage('star_not_selected.png',array(
                'onclick' => $onclick_show,
                'id' => 'hidden_'.$item->id,
                'visibility' => 'hidden',
            ),$style);

        } else {
            $onclick_hide[] = $this->getOnclickSubmit($parameters['route_add'].$item->id);

            $pricerow[] = $this->getComponentImage('star_not_selected.png',array(
                'onclick' => $onclick_hide,
                'id' => 'visible_'.$item->id
            ),$style);

            $onclick_hide[] = $this->getOnclickSubmit($parameters['route_del'].$item->id);

            $pricerow[] = $this->getComponentImage('star_selected.png',array(
                'onclick' => $onclick_show,
                'id' => 'hidden_'.$item->id,
                'visibility' => 'hidden',
            ),$style);
        }

        return $pricerow;
    }


    private function uikitGetItemImage($image)
    {
        return $this->getComponentImage($image, array(), array(
            'width' => '120',
            'height' => '120',
            'crop' => 'yes',
        ));
    }

    private function uikitGetItemInfo($item)
    {
        return $this->getComponentRow(array(
            $this->getComponentText($item->name, array('style' => 'item_card_information_name')),
            $this->getComponentText('$' . $item->price, array('style' => 'item_card_information_price'))
        ), array(), array(
            'padding' => '5 10 5 10',
            'width' => 'auto'
        ));
    }

    private function uikitGetItemCategory($item)
    {
        return $this->getComponentRow(array(
            $this->getComponentText($item->category->name, array('style' => 'item_tag'))
        ), array(), array(
            'margin' => '10 0 0 10'
        ));
    }

    private function uikitGetItemTags($item)
    {
        $maxCount = 3;
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

            $count++;
        }

        return $this->getComponentRow($tagsList, array(), array(
            'padding' => '0 4 4 2',
            'background-color' => '#ffffff',
        ));
    }

}