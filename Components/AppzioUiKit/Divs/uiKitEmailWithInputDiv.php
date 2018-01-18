<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitEmailWithInputDiv
{
    public $isLiked;

    public function uiKitEmailWithInputDiv($params = array())
    {
        /** @var BootstrapComponent $this */
        $images = isset($params['images']) ? $params['images'] : array();

        return $this->getComponentColumn(array(
            $this->getComponentRow(array(
                $this->getComponentImage('cloud_upload_dev.png', array(), array(
                    'width' => '20',
                    'margin' => '0 10 0 0'
                )),
                $this->getComponentText('Send Email', array(), array(
                    'color' => '#ffffff',
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
            $this->getEmailAttachedImages($images),
            $this->getComponentFormFieldText('', array(
                'hint' => 'To:',
                'variable' => 'recipient_email',
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
                'height' => '50',
                'margin' => '10 10 0 20',
                'vertical-align' => 'middle'
            )),
            $this->getComponentSpacer(50),
            $this->uiKitWideButton('{#send_mail#}', array(
                'onclick' => $this->sendEmailToPersonOnclick()
            ))
        ), array(), array(
            'background-color' => '#ffffff'
        ));
    }

    protected function getEmailAttachedImages($images)
    {
        $imagesList = array();
        $index = 1;

        foreach ($images as $image) {
            $imagesList[] = $this->getComponentText(' asdf', array(
                'variable' => 'send_visit_pic_' . $index,
                'selected_state' => array(
                    'style_content' => array(
                        'background-image' => $this->getImageFileName($image),
                        'background-size' => 'cover',
                        'height' => '100',
                        'width' => '100',
                        'border-color' => '#006400',
                        'border-width' => '4',
                        'border-radius' => '4',
                        'margin' => '0 5 0 5',
                    ),
                    'allow_unselect' => 1,
                    'variable_value' => 1
                ),
            ), array(
                'background-image' => $this->getImageFileName($image),
                'background-size' => 'cover',
                'height' => '100',
                'width' => '100',
                'border-radius' => '4',
                'margin' => '0 5 0 5',
            ));

            $index++;
        }

        return $this->getComponentRow($imagesList, array(), array(
            'padding' => '10 0 10 0',
            'text-align' => 'center'
        ));
    }

    protected function sendEmailToPersonOnclick()
    {
        $onclick = $this->getOnclickRoute('Publiclisting/email', false);

        $onclick[] = $this->getOnclickHideDiv('email');

        return $onclick;
    }
}