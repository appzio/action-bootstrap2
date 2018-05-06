<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

use Bootstrap\Components\BootstrapComponent;

trait uiKitTextAccordion
{

    /**
     * @param array $items
     * array(
     *      0 => array (
     *          'title' => 'title of the item',
     *          'content' => 'text content for the item'
     *      )
     * )
     * @param array $params
     * @return \stdClass
     */
    public function uiKitTextAccordion(array $items, array $params = array())
    {

        /** @var BootstrapComponent $this */
        if(is_array($items) AND !empty($items)){
            $count = 0;

            foreach ($items as $item){
                $title = trim($item['title']);
                $content = trim($item['content']);

                $onclick[] = $this->getOnclickHideElement('uikcl_plus_'.$count,['transition' => 'none']);
                $onclick[] = $this->getOnclickShowElement('uikcl_'.$count);
                $onclick[] = $this->getOnclickShowElement('uikcl_minus_'.$count,['transition' => 'none']);

                $onclick2[] = $this->getOnclickHideElement('uikcl_minus_'.$count,['transition' => 'none']);
                $onclick2[] = $this->getOnclickShowElement('uikcl_plus_'.$count,['transition' => 'none']);
                $onclick2[] = $this->getOnclickHideElement('uikcl_'.$count);

                $col[] = $this->getComponentDivider();
                $col[] = $this->getComponentSpacer(10);
                $row[] = $this->getComponentText($title,[], [
                    'vertical-align' => 'middle',
                    'margin' => '10 0 0 20',
                    'font-size' => '14',
                    'color' => $this->color_top_bar_color]);

                $row[] = $this->getComponentImage('icon-plus-blue.png',[],[
                    'floating' => '1','float' => 'right','width' => '30','margin' => '0 20 0 0','vertical-align' => 'middle']);

                $col[] = $this->getComponentRow($row,['id' => 'uikcl_plus_'.$count,'onclick' => $onclick],['width' => '100%']);


                $row2[] = $this->getComponentText($title,[], [
                    'vertical-align' => 'middle',
                    'margin' => '10 0 0 20',
                    'font-size' => '14',
                    'color' => $this->color_top_bar_color]);

                $row2[] = $this->getComponentImage('icon-minus-blue.png',[],[
                    'floating' => '1','float' => 'right','width' => '30','margin' => '0 20 0 0','vertical-align' => 'middle']);

                $col[] = $this->getComponentRow($row2,['id' => 'uikcl_minus_'.$count,'visibility'=>'hidden','onclick' => $onclick2],['width' => '100%']);

                $col[] = $this->getComponentSpacer(10);

                $col[] = $this->getComponentText($content,['visibility' => 'hidden','id' => 'uikcl_'.$count],['font-size' => '14','margin' => '0 20 10 20']);

                $output[] = $this->getComponentColumn($col,[],['vertical-align' => 'middle']);
                unset($col);
                unset($row);
                unset($row2);
                unset($onclick);
                unset($onclick2);
                $count++;
            }
        }

        $output[] = $this->getComponentDivider();
        return $this->getComponentColumn($output);
    }

}