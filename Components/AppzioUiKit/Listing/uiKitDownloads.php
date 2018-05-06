<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

use Bootstrap\Components\BootstrapComponent;

trait uiKitDownloads
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
    public function uiKitDownloads(array $items, array $params = array())
    {

        /** @var BootstrapComponent $this */
        if(is_array($items) AND !empty($items)){
            $count = 0;

            foreach ($items as $item){
                $title = trim($item['title']);
                $format = trim($item['format']);
                $size = trim($item['size']);
                $file = trim($item['file']);
                $description = trim($item['description']);

                $onclick = $this->getOnclickOpenUrl($file);

                switch($format){
                    case 'pdf':
                        $icon = 'icon-download-pdf.png';
                        break;
                    case 'doc':
                        $icon = 'icon-download-word.png';
                        break;
                    case 'ppt':
                        $icon = 'icon-download-powerpoint.png';
                        break;
                    case 'ptx':
                        $icon = 'icon-download-powerpoint.png';
                        break;
                    case 'xls':
                        $icon = 'icon-download-excel.png';
                        break;
                    case 'lsx':
                        $icon = 'icon-download-excel.png';
                        break;
                    default:
                        $icon = 'icon-download-general.png';
                        break;
                }

                $row[] = $this->getComponentImage($icon,[],['width' => '10%','margin' => '0 10 0 0']);
                $row[] = $this->getComponentText($title,[],['color' => $this->color_top_bar_color,'font-size' => '12','width' => '60%']);
                $row[] = $this->getComponentText(' (' .$size .')',[],[
                    'color' => $this->color_top_bar_color,'font-size' => '12', 'width' => '30%',
                    'floating' => 1,'float' => 'right','text-align' => 'right','vertical-aling' => 'top']);
                
                $output[] = $this->getComponentRow($row,['onclick' => $onclick],['margin' => '10 20 0 20','vertical-align' => 'top']);
                $output[] = $this->getComponentText($description,[],['margin' => '5 20 10 60','font-size' => '12']);
                $output[] = $this->getComponentDivider();

                unset($row);


                $count++;
            }
        }

        return $this->getComponentColumn($output);
    }

}