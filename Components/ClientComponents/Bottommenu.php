<?php

namespace Bootstrap\Components\ClientComponents;
use Bootstrap\Views\BootstrapView;
use Helper;

/**
 * Trait Bottommenu
 * @package Bootstrap\Components\Elements
 */
trait Bottommenu {

    /**
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'selected_state' => 'style-class-name',
     * 'variable'   => 'variablename',
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'style' => 'style-class-name',
     * );
     * </code>
     * @param array $styles -- please see the link for more information about parameters [link] Bootstrap\Components\ComponentStyles
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
        $background = $this->bottom_menu_background_color;

        if(strlen($background) > 7){
            $background = '#' .substr($background, -6);
        }

        $colorhelp = new \Color($background);
        $hilite = $colorhelp->darken();

        foreach($menudata as $menuitem){
            /* show flag */
            if($menuitem['slug'] == 'mailbox' AND $this->model->msgcount){
                $menuitem['flag'] = $this->model->msgcount;
            }

            if($menuitem['slug'] == 'approvals' AND $this->model->msgcount){
                $menuitem['flag'] = $this->model->msgcount;
                $menuitem['flag_color'] = '#87D46D';
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

        if(isset($this->model->bottom_menu_config['hide_text']) AND $this->model->bottom_menu_config['hide_text']) {
            $height = 50;
        } else {
            $height = 60;
        }

        $output[] = $this->getComponentColumn($row,array(),array('height' => $height,'background-color' => '#000000'));
        return $output;
    }

    /**
     * @param $item
     * @param $count
     * @param $current
     * @param $hilite
     * @return \stdClass
     */
    private function getItem($item,$count,$current,$hilite)
    {
        /** @var BootstrapView $this */

        $text_color = $this->bottom_menu_text_color;

        if($current == $count){
            $width = round($this->screen_width / $count,0);
            $others = $width*($count-1);
            $width = $this->screen_width - $others;
        } else {
            $width = round($this->screen_width / $count,0);
        }

        if ($item['action_config'] == $this->model->action_id AND $item['action'] == 'open-action' AND isset($item['icon_active']) AND $item['icon_active']) {
             $row[] = $this->getComponentImage($item['icon_active'], array(),array('height' => 25, 'margin' => '8 0 5 0'));
        } elseif($item['action_config'] == $this->model->branchobj->id AND $item['action'] == 'open-branch' AND isset($item['icon_active']) AND $item['icon_active']) {
             $row[] = $this->getComponentImage($item['icon_active'], array(),array('height' => 25,'margin' => '8 0 5 0'));
        } else {
            if ($item['icon']) $row[] = $this->getComponentImage($item['icon'], array(),array('height' => 25, 'margin' => '8 0 5 0'));
        }

        if(isset($this->model->bottom_menu_config['hide_text']) AND $this->model->bottom_menu_config['hide_text']){
            $height = 50;
        } else {
            $row[] = $this->getComponentText($item['text'], array(),array(
                'color' => $text_color, 'font-size' => '10', 'width' => $width, 'text-align' => 'center',
                'margin' => '0 0 8 0'));
            $height = 60;
        }

        /* set the menu action */
        $onclick = new \stdClass();
        $onclick->action = $item['action'];
        $onclick->action_config = $item['action_config'];
        $onclick->transition = 'fade';
        $onclick->back_button = true;

        if ($item['open_popup'] == 1) $onclick->open_popup = 1;
        if ($item['sync_open'] == 1) $onclick->sync_open = 1;
        if ($item['sync_close'] == 1) $onclick->sync_close = 1;

        $slug = $item['slug'];

        if(isset($this->model->bottom_menu_config['flags'][$slug]) AND $this->model->bottom_menu_config['flags'][$slug]){
            $flag_color = isset($this->model->bottom_menu_config['flag_color']) ?$this->model->bottom_menu_config['flag_color'] : '#F80F26';
            $flag_text_color = isset($this->model->bottom_menu_config['flag_text_color']) ?$this->model->bottom_menu_config['flag_text_color'] : '#ffffff';
            $some[] = $this->getComponentText($this->model->bottom_menu_config['flags'][$slug],array(),array(
               'font-size' => '11',
               'background-color' => $flag_color,
               'color' => $flag_text_color,
               'padding' => '3 6 3 6',
               'border-radius' => '9',
               'height' => '18',
               'text-align' => 'center'
           ));

            $row[] = $this->getComponentColumn($some,array(),array('height' => '21','width' => $width/2,'text-align' => 'right','margin' => '4 0 0 0','vertical-align' => 'top', 'floating' => 1));

        }

        /* add a number flag on the icon */
        if(isset($item['flag']) AND $item['flag']){

            if(isset($item['flag_color'])){
                $color = $item['flag_color'];
                $some[] = $this->getComponentText($item['flag'],array(),array(
                    'font-size' => '11','background-color' => $color,'color' => '#ffffff',
                    'padding' => '3 6 3 6',
                    'border-radius' => '9',
                    'height' => '18',
                    'text-align' => 'center'
                ));

            } else {
                $color = '#F80F26';

                $some[] = $this->getComponentText($item['flag'],array(),array(
                    'font-size' => '11','background-color' => $color,'color' => '#ffffff',
                    'padding' => '3 6 3 6',
                    'border-radius' => '4',
                    'border-color' => '#ffffff','text-align' => 'center'
                ));

            }

            $row[] = $this->getComponentColumn($some,array(),array('height' => '21','width' => $width/2,'text-align' => 'right','margin' => '4 0 0 0','floating' => 1,'float' => 'right'));
        }

        if ($item['action_config'] == $this->model->action_id AND $item['action'] == 'open-action') {
            return $this->getComponentColumn($row, array('onclick' => $onclick),array('width' => $width, 'text-align' => 'center', 'background-color' => $hilite,'height' => $height));
        } elseif($item['action_config'] == $this->model->branchobj->id AND $item['action'] == 'open-branch'){
            return $this->getComponentColumn($row, array('onclick' => $onclick),array('width' => $width, 'text-align' => 'center', 'background-color' => $hilite,'height' => $height));
        } else {
            return $this->getComponentColumn($row,array('onclick' => $onclick),array('width' => $width,'text-align' => 'center','height' => $height));
        }
    }
}