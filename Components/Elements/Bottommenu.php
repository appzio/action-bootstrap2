<?php

namespace Bootstrap\Components\Elements;
use Bootstrap\Views\BootstrapView;
use Helper;

trait Bottommenu {

    /**
     * @param $content string, no support for line feeds
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'selected_state' => 'style-class-name',
     * 'variable'   => 'variablename',
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'style' => 'style-class-name',
     * );
     * </code>
     * @param array $styles
     * <code>
     * $array = array(
     * 'margin' => '0 0 0 0',
     * 'padding' => '0 0 0 0',
     * 'width' => '200', // or 100%
     * 'height' => '400',
     * 'max_height' => '500',
     * 'background-color' => '#ffffff',
     * 'background-image' => 'filename.png',
     * 'background-size' => 'cover', // or 'contain', 'top' (default)
     * 'crop' => 'round', // or 'yes'
     * 'vertical-align' => 'middle',
     * 'text-align' => 'center',
     * 'font-size' => '14',
     * 'font-ios' => 'Roboto',
     * 'font-weight' => 'Bold',
     * 'font-style' => 'Italic',
     * 'font-android' => 'Roboto',
     * 'color' => '#000000',
     * 'white-space' => 'nowrap',
     * 'children_style' => 'style-class-name' // this is used only in menu, progress and field-list components
     * 'floating' => '1',
     * 'float' => 'right',
     * 'parent_style' => 'style-class-name',
     * 'shadow-color' => '#000000',
     * 'shadow-offset' => '0 1',
     * 'shadow-radius' => '5',
     * 'border-width' => '1',
     * 'border-color' => '#000000',
     * 'border-radius' => '4',
     * 'opacity' => '0.4',
     * );
     * </code>
     * @return \array
     */

    public function getComponentBottommenu(array $parameters=array(),array $styles=array()) {
        /** @var BootstrapView $this */

        if(!$this->model->bottom_menu_id){
            return array();
        }


        foreach ($this->model->menus['menus'] as $menu){
            if($menu['id'] == $this->model->bottom_menu_id){
                $menudata = $menu['items'];
            }
        }

        if(!isset($menudata)){
            $output[] = $this->getComponentText('Menu not defined correctly',array(),array('text-align' => 'center'));
            return $output;
        }

        $count = count($menudata);
        $counter = 1;

        $background = $this->model->bottom_menu_color_background ? $this->model->bottom_menu_color_background : $this->color_top_bar_color;

        if($this->model->bottom_menu_color_background){
            $colorhelp = new \Color($this->model->bottom_menu_color_background);
            $hilite = $colorhelp->darken();
        } else {
            $hilite = $this->color_topbar_hilite;
        }

        foreach($menudata as $menuitem){
            /* show flag */
            if($menuitem['slug'] == 'mailbox' AND $this->model->msgcount){
                $menuitem['flag'] = $this->model->msgcount;
            }
            $column[] = $this->getItem($menuitem,$count,$counter,$hilite);
            $counter++;
        }


        if(isset($column)){
            $row[] = $this->getComponentText('',array(),array('height' => '2', 'background-color' => $hilite));
            $row[] = $this->getComponentRow($column,array(),array('background-color' => $background));
        } else {
            $row[] = $this->getComponentText('No menu items found',array(),array('height' => '2', 'background-color' => $hilite));
        }

        $output[] = $this->getComponentColumn($row,array(),array('height' => '60'));
        return $output;
    }

    private function getItem($item,$count,$current,$hilite)
    {

        $text_color = $this->model->bottom_menu_color_text ? $this->model->bottom_menu_color_text : $this->color_top_bar_text_color;

        if($current == $count){
            $width = round($this->screen_width / $count,0);
            $others = $width*($count-1);
            $width = $this->screen_width - $others;
        } else {
            $width = round($this->screen_width / $count,0);
        }

        if ($item['icon']) $row[] = $this->getComponentImage($item['icon'], array(),array('height' => 25, 'margin' => '8 0 5 0'));

        $row[] = $this->getComponentText($item['text'], array(),array(
            'color' => $text_color, 'font-size' => '10', 'width' => $width, 'text-align' => 'center',
            'margin' => '0 0 8 0'));

        /* set the menu action */
        $onclick = new \stdClass();
        $onclick->action = $item['action'];
        $onclick->action_config = $item['action_config'];
        $onclick->transition = 'fade';
        if ($item['open_popup'] == 1) $onclick->open_popup = 1;
        if ($item['sync_open'] == 1) $onclick->sync_open = 1;
        if ($item['sync_close'] == 1) $onclick->sync_close = 1;

        /* add a number flag on the icon */
        if(isset($item['flag']) AND $item['flag']){
            $some[] = $this->getComponentText($item['flag'],array(),array(
                'font-size' => '11','background-color' => '#F80F26','color' => '#ffffff','padding' => '3 6 3 6','border-radius' => '4',
                'border-color' => '#ffffff','text-align' => 'center'
            ));
            $row[] = $this->getComponentColumn($some,array(),array('height' => '21','width' => $width/2,'text-align' => 'right','margin' => '4 0 0 0','floating' => 1,'float' => 'right'));
        }

        if ($item['action_config'] == $this->model->action_id AND $item['action'] == 'open-action') {
            return $this->getComponentColumn($row, array('onclick' => $onclick),array('width' => $width, 'text-align' => 'center', 'background-color' => $this->color_topbar_hilite,'height' => '60'));
        } elseif($item['action_config'] == $this->model->branchobj->id AND $item['action'] == 'open-branch'){
            return $this->getComponentColumn($row, array('onclick' => $onclick),array('width' => $width, 'text-align' => 'center', 'background-color' => $this->color_topbar_hilite,'height' => '60'));
        } else {
            return $this->getComponentColumn($row,array('onclick' => $onclick),array('width' => $width,'text-align' => 'center','height' => '60'));
        }




    }


}