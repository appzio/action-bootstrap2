<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;
use Bootstrap\Components\BootstrapComponent;

trait uiKitPurchaseDiv
{
    public function uiKitPurchaseDiv($div_id, $icon, $title, $text, $product_id_ios, $product_id_android, $return_output = false)
    {

        $output = $this->getComponentColumn(array(
/*            $this->getComponentImage('icon-close.png', array(
                'onclick' => $this->getOnclickHideDiv($div_id),
            ),array(
                'width' => '30',
                'height' => '30',
                'floating' => '1',
                'float' => 'right',
                'margin' => '10 10 0 0',
            )),*/

            $this->getComponentRow(array(
                $this->getComponentImage($icon, array(),array(
                    'width' => '130',
                    'margin' => '25 0 0 0',
                )),
            ), array(),array(
                'text-align' => 'center',
                'margin' => '10 20 15 20',
            )),

            $this->getComponentRow(array(
                $this->getComponentText($title, array(),array(
                    'font-size' => '24',
                    'text-align' => 'center',
                    'font-android' => 'Roboto-bold',
                )),
            ), array(),array(
                'width' => 'auto',
                'text-align' => 'center',
                'margin' => '0 30 15 30',
            )),
            $this->getComponentRow(array(
                $this->getComponentText($text, array(),array(
                    'text-align' => 'center',
                )),
            ), array(),array(
                'width' => 'auto',
                'margin' => '0 30 25 30',
            )),
            $this->getComponentRow(array(
                $this->getComponentText('{#buy_now#}', array(
                    'onclick' => $this->getOnclickPurchase($product_id_ios, $product_id_android)),
                    array(
                    'width' => '100%',
                    'background-color' => '#fec02e',
                    'color' => '#1d0701',
                    'padding' => '13 5 13 5',
                    'text-align' => 'center',
                )),
            ), array(),array(
                'width' => '100%',
                'text-align' => 'center',
                )),
        ), array(),array(
            'width' => '100%',
            'background-color' => '#FFFFFF',
            'border-radius' => '8',
            'shadow-color' => '#33000000',
            'shadow-radius' => 3,
            'shadow-offset' => '0 1',
        ));

        return $output;


    }
}