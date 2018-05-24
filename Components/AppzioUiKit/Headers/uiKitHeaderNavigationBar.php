<?php

namespace Bootstrap\Components\AppzioUiKit\Headers;

trait uiKitHeaderNavigationBar {

    /**
     * Renders uikit header with background and navigation block
     * @param string $text
     * @return object
     */
    public function uiKitHeaderNavigationBar(string $text, string $image, $parameters = array(), $styles = array()){

        $filename = $this->getImageFileName($image, array(
            'imgwidth' => '1680',
            'imgheight' => '770',
            'priority' => 9,
        ));

        return $this->getComponentRow(array(
            $this->uiKitHeaderNavigationBarControls( $text ),
        ), array(), array(
            'vertical-align' => 'top',
            'background-image' => $filename,
            'background-size' => 'cover',
            'margin' => '0 0 5 0',
            'width' => $this->screen_width,
            'height' => $this->screen_height / 4,
        ));
    }

    protected function uiKitHeaderNavigationBarControls( $text ) {
        return $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentImage('arrow-back-white-v2.png', array(
                    'onclick' => $this->getOnclickGoHome()
                ), array(
                    'width' => '15',
                )),
                $this->getComponentText($text, [], [
                    'width' => $this->screen_width - 15,
                    'vertical-align' => 'middle',
                    'text-align' => 'center',
                    'color' => '#ffffff',
                ])
            ))
        ), array(), array(
            'width' => '100%',
            'height' => '100',
            'padding' => '15 15 15 15',
            'background-image' => $this->getImageFileName('shadow-image-wide-inverted.png', array(
                'imgwidth' => '1366',
                'imgheight' => '768',
            )),
            'background-size' => 'cover',
        ));
    }

}