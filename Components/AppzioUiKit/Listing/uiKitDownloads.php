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

                $col[] = $this->getComponentImage($icon,[],['width' => '10%','margin' => '0 10 0 10']);

                $textcontent[] = $this->getComponentText($title,[],['color' => $this->color_top_bar_color,'font-size' => '12','width' => 'auto']);
                $textcontent[] = $this->getComponentText(' (' .$size .')',[],[
                    'color' => $this->color_top_bar_color,'font-size' => '12', 'width' => '30%',
                    'floating' => 1,'float' => 'right','text-align' => 'right','vertical-aling' => 'top']);
                
                $textcolumn[] = $this->getComponentRow($textcontent,[],['vertical-align' => 'top','margin' => '0 0 0 0']);
                $textcolumn[] = $this->getComponentText($description,[],['margin' => '5 0 10 0','font-size' => '12']);

                $col[] = $this->getComponentColumn($textcolumn,[],['width' => '80%']);
                $output[] = $this->getComponentRow($col,['onclick' => $onclick],['margin' => '10 0 10 0']);
                $output[] = $this->getComponentDivider();

                unset($textcontent);
                unset($textcolumn);
                unset($col);


                $count++;
            }
        }

        return $this->getComponentColumn($output);
    }

}