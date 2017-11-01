<?php

namespace Bootstrap\Components\AppzioUiKit\Controls;

use Bootstrap\Components\BootstrapComponent;

trait uiKitHierarchicalCategories
{


    public $current_category_info;
    public $submit_click;
    public $tab;

    /**
     * Takes a specially formatted array to display a hierarchical, collapsible
     * list up to four levels. See actionMitems > Categories traig for more clues on formatting
     * the array. This component will submit only single item and close the popup on selection.
     *
     * Note that the final ordering of the elements happens here in the component, so the
     * model can send the results in any order.
     *
     * @param $categories
     * @param $onclick
     * Onclick the submit upon selection.
     * @return mixed
     */

    public function uiKitHierarchicalCategories($categories,$onclick_save_route=false,$tab=false)
    {

        $this->submit_click = $onclick_save_route;
        $this->tab = $tab;

        if($tab){
            $this->current_category_info['id'] = 0;
            $out = $this->uiKitHierarchicalCategoriesGetRow('{#no_category_filtering#}', '');
            $out[] = $this->getComponentSpacer('10');
        }


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
                $onclick[] = $this->getOnclickShowElement('sub_'.$id.'_*',array('transition' => 'none'));
                $onclick[] = $this->getOnclickShowElement('subcollapsed_'.$id.'_*',array('transition' => 'none'));
            }
        } else {
            $onclick[] = $this->getOnclickHideElement($id.'_expanded',array('transition' => 'none'));
            $onclick[] = $this->getOnclickShowElement($id.'_collapsed',array('transition' => 'none'));

            if($this->current_category_info['all_children']){
                $onclick[] = $this->getOnclickHideElement('sub_'.$id.'_*',array('transition' => 'none'));
                $onclick[] = $this->getOnclickHideElement('subexpanded_'.$id.'_*',array('transition' => 'none'));
            }
        }

        return $onclick;
    }

    private function uiKitHierarchicalCategoriesGetRow($name,$icon,$level='first'){
        if($level == 'first'){
            $out[] = $this->uiKitDivider();
        }

        $id = $this->current_category_info['id'];

        $var = $this->model->getVariableId('category_name') ? $this->model->getVariableId('category_name') : '';

        $params = array();
        $styles = array();

        $row[] = $this->getComponentText($name,array('style' => 'ukit_hierarchical_'.$level.'level'));

        if(empty($this->current_category_info['children'])){
            $params['onclick'][] = $this->getOnclickSubmit($this->submit_click.$id);

            if($this->tab){
                $params['onclick'][] = $this->getOnclickTab(1);
                if($var){
                    $params['onclick'][] = $this->getOnclickSetVariables(array($var => $this->model->getCategoryPath($id)));
                }
            } else {
                $params['onclick'][] = $this->getOnclickClosePopup();
            }

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
            'id' => 'subcollapsed_'.$parent_id.'_'.$id.'_collapsed',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id)));

        $out = $this->uiKitHierarchicalCategoriesGetRow($name,'formkit-selector-arrow-down.png','second');

        $output[] = $this->getComponentColumn($out,array(
            'id' => 'subexpanded_'.$parent_id.'_'.$id.'_expanded',
            'visibility' => 'hidden',
            'onclick' => $this->uiKitHierarchicalCategoriesOnclicks($id,'expanded')));

        return $this->getComponentColumn($output,array('id' => 'sub_'.$parent_id.'_'.$id,'visibility' => 'hidden'));

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