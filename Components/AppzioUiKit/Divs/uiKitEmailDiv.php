<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitEmailDiv
{
    public $isLiked;

    public function uiKitEmailDiv($params = array())
    {
        /** @var BootstrapComponent $this */
        return $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentImage('cloud_upload_dev.png'),
                $this->getComponentText('Send Email', array(), array(
                    'background-color' => '#4a4a4a',
                    'color' => '#ffffff',
                    'padding' => '10 20 10 20',
                    'font-ios' => 'OpenSans',
                    'font-size' => '14',
                    'width' => '100%',
                ))
            ), array(), array(
                'shadow-color' => '#33000000',
                'shadow-radius' => '1',
                'shadow-offset' => '0 3',
                'margin' => '0 0 20 0'
            )),
            $this->getComponentFormFieldText('', array(
                'hint' => 'To:'
            ), array(
                'margin' => '0 20 0 20'
            )),
            $this->getComponentSpacer('1', array(), array(
                'background-color' => '#dadada',
                'opacity' => '0.5',
                'margin' => '0 20 0 20'
            )),
            $this->getComponentFormFieldTextArea('', array(
                'hint' => 'Message:'
            ), array(
                'margin' => '0 20 0 20'
            )),
            $this->getComponentSpacer('1', array(), array(
                'background-color' => '#dadada',
                'opacity' => '0.5',
                'margin' => '0 20 0 20'
            )),
            $this->getComponentRow(array(
                $this->getComponentText('{#send_copy_to_myself#}', array(), array(
                    'color' => '#7b7b7b',
                )),
                $this->getComponentFormFieldOnoff(array(), array(
                    'floating' => 1,
                    'float' => 'right',
                    'margin' => '0 10 0 0'
                ))
            ), array(), array(
                'margin' => '10 10 0 20',
                'vertical-align' => 'middle'
            )),
            $this->getComponentSpacer(250),
            $this->uiKitWideButton('{#send_mail#}')
        ), array(), array(
            'background-color' => '#ffffff'
        ));
    }
}