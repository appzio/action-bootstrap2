<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitEmailDiv
{
    public $isLiked;

    public function uiKitEmailDiv($params = array())
    {
        /** @var BootstrapComponent $this */
        $images = isset($params['images']) ? $params['images'] : array();

        return $this->getComponentColumn(array(
            $this->uiKitDivHeader('Send Email', array(
                'image' => 'cloud_upload_dev.png',
                'close_icon' => 'cross-sign.png',
                'div_id' => 'email'
            )),
            $this->getAttachedImagesRow($images),
            $this->getComponentText('', array(
                'variable' => 'recipient_email',
            ), array(
                'margin' => '10 20 10 20'
            )),
            $this->getComponentFormFieldText('', array(
                'hint' => 'To:',
                'variable' => 'recipient_email',
                'visibility' => 'hidden',
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
                'onclick' => $this->sendEmailToPerson()
            ))
        ), array(), array(
            'background-color' => '#ffffff'
        ));
    }

    protected function getAttachedImagesRow($images)
    {
        $imagesList = array();
        $index = 1;

        foreach ($images as $image) {
            $imagesList[] = $this->getComponentText(' ', array(
                'variable' => 'send_visit_pic_' . $index,
                'selected_state' => array(
                    'style_content' => array(
                        'background-image' => $this->getImageFileName($image),
                        'background-size' => 'cover',
                        'height' => '100',
                        'width' => '100',
                        'border-color' => '#fdca42',
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

    protected function sendEmailToPerson()
    {
        $onclick = $this->getOnclickRoute('Publiclisting/email', false);

        $onclick[] = $this->getOnclickHideDiv('email');

        return $onclick;
    }
}