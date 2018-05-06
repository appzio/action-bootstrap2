<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

use Bootstrap\Components\BootstrapComponent;

trait uiKitTableData
{

    /**
     * @param array $items
     * array(
     *      0 => array (
     *          'header' => 'title of the item',
     *          'columns' => 'text content for the item',
     *          'data' => array(
     *              0 => 'title', 'values' => array('1','2')
     *          )
     *      )
     * )
     * @param array $params
     * @return \stdClass
     */
    public function uiKitTableData(array $items, array $params = array())
    {

        /** @var BootstrapComponent $this */


        if(!isset($items['header']) OR !isset($items['columns']) OR !isset($items['data'])){
            return $this->getComponentText('{#no_data#}');
        }

        $minus = count($items['columns']) * 20;
        $width = 100-$minus .'%';

        $row[] = $this->getComponentText($items['header'],[],['margin' => '0 0 0 0', 'width' => $width,'font-size' => '14']);

        foreach($items['columns'] as $headercolumn){
            $row[] = $this->getComponentText($headercolumn,[],['width' => "20%",'font-size' => '14','text-align' => 'right']);
        }
        
        $col[] = $this->getComponentRow($row,[],['background-color' => '#E1E4E3','height' => '40','padding' => '0 20 0 20']);


        unset($row);

        foreach($items['data'] as $line){
            $row[] = $this->getComponentText($line['title'],[],[
                'width' => $width,'font-size' => '12','height' => '40', 'vertical-align' => 'middle']);

            foreach($line['columns'] as $val){
                $val = trim($val);
                $row[] = $this->getComponentText($val,[],[
                    'width' => '20%','font-size' => '12','margin','text-align' => 'right',
                    'height' => '40', 'vertical-align' => 'middle']);
            }
            
            $col[] = $this->getComponentRow($row,[],['margin' => '0 20 0 20','height' => '40','vertical-align' => 'middle']);
            $col[] = $this->getComponentDivider();
            unset($row);
        }


        return $this->getComponentColumn($col);



    }

}