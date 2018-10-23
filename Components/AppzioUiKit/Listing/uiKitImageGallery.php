<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;

use Bootstrap\Components\BootstrapComponent;

trait uiKitImageGallery
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
    public function uiKitImageGallery(array $items, array $params = array())
    {

        $rows = array_chunk($items, 4);
        $width = round(($this->screen_width - 80) / 4, 0);

        foreach ($rows as $imagerow) {
            foreach ($imagerow as $image) {
                $col[] = $this->getComponentImage($image, [
                    'img_width' => '300',
                    'onclick' => $this->getOnclickSubmit('Controller/selectimage/' . $image, ['viewport' => 'top'])
                ], [
                    'width' => $width, 'height' => $width, 'crop' => 'yes', 'border-radius' => 4,
                    'margin' => '5 5 0 0'
                ]);
            }

            $output[] = $this->getComponentRow($col);
            unset($col);
        }

        /** @var BootstrapComponent $this */
        return $this->getComponentColumn($output, [
            'id' => 'image_gallery',
            'visibility' => 'hidden'
        ], [
            'margin' => '0 30 20 30',
            'text-align' => 'center'
        ]);
    }

}