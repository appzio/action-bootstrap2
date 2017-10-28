<?php

namespace Bootstrap\Components\AppzioUiKit\Controls;

use Bootstrap\Components\BootstrapComponent;

trait uiKitHierarchicalCategories
{


    public $current_category_info;

    /**
     * Takes a specially formatted array to display a hierarchical, collapsible
     * list up to four levels. See actionMitems > Model for more clues on formatting the array.
     * This component will submit only single item and close the popup on selection.
     *
     * @param $categories
     * @param $onclick
     * Onclick the submit upon selection.
     * @return mixed
     */

    public function uiKitHierarchicalCategories($categories,$onclick=false)
    {

        foreach($categories as $category) {

            $this->current_category_info = $category;

            if (empty($category['parents'])) {
                $out[] = $this->uiKitHierarchicalCategoriesMainLevel($category['title'], $category['id']);

                if(!empty($category['children'])) {
                    foreach ($category['children'] as $child) {
                        $this->current_category_info = $categories[$child];
                        $out[] = $this->uiKitHierarchicalCategoriesSecondLevel($this->current_category_info['title'], $this->current_category_info['id'], $this->current_category_info['parent_id']);

                        if ($this->current_category_info['children']) {
                            $thirdlevel = $this->current_category_info['children'];

                            foreach ($thirdlevel as $thirdchild) {
                                $this->current_category_info = $categories[$thirdchild];
                                $out[] = $this->uiKitHierarchicalCategoriesThirdLevel($this->current_category_info['title'], $this->current_category_info['id'], $this->current_category_info['parent_id']);

                                $fourthlevel = $this->current_category_info['children'];
                                if (!empty($fourthlevel)) {
                                    foreach ($fourthlevel as $fourthchild) {
                                        $this->current_category_info = $categories[$fourthchild];
                                        $out[] = $this->uiKitHierarchicalCategoriesFourthLevel($this->current_category_info['title'], $this->current_category_info['id'], $this->current_category_info['parent_id']);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        
        if(isset($out)){
            return $this->getComponentColumn($out);
        } else {
            return $this->getComponentText('{#no_categories_found#}',array('style' => 'ukit_hierarchical_firstlevel'));
        }

    }

    private function uiKitHierarchicalCategoriesOnclicks($id,$state='collapsed',$firstlevel=false){

        if($state == 'collapsed'){
            $onclick[] = $this->getOnclickShowElement($id.'_expanded',array('transition' => 'none'));
            $onclick[] = $this->getOnclickHideElement($id.'_collapsed',array('transition' => 'none'));

            if($this->current_category_info['children']){
                foreach($this->current_category_info['children'] as $cat){
                    $onclick[] = $this->getOnclickShowElement($cat,array('transition' => 'none'));
                }
            }
        } else {
            $onclick[] = $this->getOnclickHideElement($id.'_expanded',array('transition' => 'none'));
            $onclick[] = $this->getOnclickShowElement($id.'_collapsed',array('transition' => 'none'));

            if($this->current_category_info['all_children']){
                foreach($this->current_category_info['all_children'] as $cat){
                    $onclick[] = $this->getOnclickHideElement($cat,array('transition' => 'none'));
                    $onclick[] = $this->getOnclickHideElement($cat.'_expanded',array('transition' => 'none'));
                    $onclick[] = $this->getOnclickShowElement($cat.'_collapsed',array('transition' => 'none'));
                }
            }

        }

        return $onclick;
    }

    private function uiKitHierarchicalCategoriesGetRow($name,$icon,$level='first'){
        if($level == 'first'){
            $out[] = $this->uiKitDivider();
        }

        $params = array();
        $styles = array();

        $row[] = $this->getComponentText($name,array('style' => 'ukit_hierarchical_'.$level.'level'));

        if(empty($this->current_category_info['children'])){
            $params['onclick'] = $this->getOnclickClosePopup(array(
                //'set_variables_data' => array($this->model->getVariableId('category') => $this->current_category_info['name']
                )
            );

            $row[] = $this->getComponentImage('uikit_selector_green_icon.png',array('style' => 'ukit_selector_arror'));
        } else {
            $row[] = $this->getComponentImage($icon,array('style' => 'ukit_selector_arror'));
        }

        if($level == 'first'){
            $styles['background-color'] = '#E1E4E3';
        }

        $out[] = $this->getComponentRow($row,$params,$styles);


        switch($level){
            case 'first':
                $out[] = $this->uiKitDivider();
                break;

            case 'second':
                $out[] = $this->getComponentText('',array(),array('parent_style' => 'uikit_divider','margin' => '0 0 0 45'));
                break;

            case 'third':
                $out[] = $this->getComponentText('',array(),array('parent_style' => 'uikit_divider','margin' => '0 0 0 45'));
                break;

            case 'fourth':
                $out[] = $this->getComponentText('',array(),array('parent_style' => 'uikit_divider','margin' => '0 0 0 60'));
                break;
        }
        return $out;

    }

    private function uiKitHierarchicalCategoriesMainLevel($name,$id){

        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-fwd.png');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_collapsed',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id,'collapsed',true)));

        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-down.png');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_expanded',
            'visibility' => 'hidden',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id,'expanded',true)));

        return $this->getComponentColumn($output,array(),array('margin' => '0 0 1 0'));
    }



    private function uiKitHierarchicalCategoriesSecondLevel($name,$id,$parent_id){
        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-fwd.png','second');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_collapsed',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id)));

        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-down.png','second');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_expanded',
            'visibility' => 'hidden',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id,'expanded')));

        return $this->getComponentColumn($output,array('id' => $id,'visibility' => 'hidden'));

    }
    private function uiKitHierarchicalCategoriesThirdLevel($name,$id,$parent_id){
        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-fwd.png','third');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_collapsed',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id)));

        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-down.png','third');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_expanded',
            'visibility' => 'hidden',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id,'expanded')));

        return $this->getComponentColumn($output,array('id' => $id,'visibility' => 'hidden'));

    }
    private function uiKitHierarchicalCategoriesFourthLevel($name,$id,$parent_id){
        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-fwd.png','fourth');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_collapsed',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id)));

        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-down.png','fourth');

        $output[] = $this->getComponentColumn($out,array(
            'id' => $id.'_expanded',
            'visibility' => 'hidden',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id,'expanded')));

        return $this->getComponentColumn($output,array('id' => $id,'visibility' => 'hidden'));

    }

}