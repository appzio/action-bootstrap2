<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitEmailDiv
{
    public $isLiked;

    public function uiKitEmailDiv($params = array())
    {
        /** @var BootstrapComponent $this */
        $to = $this->model->getSubmittedVariableByName('to_email');

        if (empty($to)) {
            $to = '';
        }

        return $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentImage('cloud_upload_dev.png', array(), array(
                    'width' => '20',
                    'margin' => '0 10 0 0'
                )),
                $this->getComponentText('Send Email', array(), array(
                    'color' => '#ffffff',
                    'font-ios' => 'OpenSans',
                    'font-size' => '14',
                    'width' => '100%',
                ))
            ), array(), array(
                'padding' => '10 20 10 20',
                'background-color' => '#4a4a4a',
                'shadow-color' => '#33000000',
                'shadow-radius' => '1',
                'shadow-offset' => '0 3',
                'margin' => '0 0 20 0'
            )),
            $this->getComponentText($to, array(
                'variable' => 'to_email'
            ), array(
                'margin' => '10 20 10 20'
            )),
            $this->getComponentFormFieldText($to, array(
                'hint' => 'To:',
                'variable' => 'to_email',
                'visibility' => 'hidden'
            ), array(
                'margin' => '0 20 0 20'
            )),
            $this->getComponentSpacer('1', array(), array(
                'background-color' => '#dadada',
                'opacity' => '0.5',
                'margin' => '0 20 0 20'
            )),
            $this->getComponentFormFieldTextArea('', array(
                'hint' => 'Message:',
                'variable' => 'message'
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
                $this->getComponentFormFieldOnoff(array(
                    'variable' => 'send_copy'
                ), array(
                    'floating' => 1,
                    'float' => 'right',
                    'margin' => '0 10 0 0'
                ))
            ), array(), array(
                'margin' => '10 10 0 20',
                'vertical-align' => 'middle'
            )),
            $this->getComponentSpacer(250),
            $this->uiKitWideButton('{#send_mail#}', array(
                'onclick' => $this->sendEmailToPerson()
            ))
        ), array(), array(
            'background-color' => '#ffffff'
        ));
    }

    protected function sendEmailToPerson()
    {
        $onclick = $this->getOnclickRoute('Publiclisting/email', false);

        $onclick[] = $this->getOnclickHideDiv('email');

        return $onclick;
    }
}