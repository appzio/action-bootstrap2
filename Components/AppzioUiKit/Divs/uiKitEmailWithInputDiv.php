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
        $action = isset($params['action']) ? $params['action'] : 'Controller/email';
        $subtitle = isset($params['subtitle']) ? $params['subtitle'] : '';
        
        return $this->getComponentColumn(array(
            $this->uiKitDivHeader('Send Email', array(
                'close_icon' => 'cross-sign.png',
                'div_id' => 'email',
            )),
            $this->getEmailDivSubtitle($subtitle),
            $this->getEmailAttachedImages($images),
            $this->getComponentFormFieldText('', array(
                'hint' => 'To:',
                'variable' => 'recipient_email',
                'id' => 'send_email_to',
                'suggestions_update_method' => 'getemails',
                'suggestions' => [],
                'suggestions_placeholder' => $this->getComponentText('$value', array(), array(
                    'font-size' => 15,
                    'color' => '#333333',
                    'background-color' => '#ffffff',
                    'padding' => '12 10 12 10',
                )),
                'token_placeholder' => $this->getComponentRow([
                    $this->getComponentText('$value', [], [
                        'color' => '#000000',
                        'padding' => '3 5 3 5',
                    ])
                ], [], [
                    'background-color' => '#f6f6f6',
                    'padding' => '3 3 3 3',
                    'margin' => '3 0 3 0',
                    'border-radius' => '5',
                ]),
            ), array(
                'padding' => '0 0 0 0',
                'margin' => '10 20 10 20',
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
                'margin' => '5 10 5 10',
                'height' => '75'
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
                'onclick' => $this->sendEmailToPersonOnclick($action)
            ))
        ), array(
            'scrollable' => 1
        ), array(
            'background-color' => '#ffffff'
        ));
    }

    protected function getEmailDivSubtitle($subtitle)
    {
        return $this->getComponentText($subtitle, array(), array(
            'text-align' => 'center',
            'color' => '#797f82',
            'font-size' => '14'
        ));
    }

    protected function getEmailAttachedImages($images)
    {
        $imagesList = array();
        $index = 0;

        foreach ($images as $image) {
            $imagesList[] = $this->getComponentText(' ', array(
                'variable' => 'send_pic_' . $index,
                'selected_state' => $this->getImageSelectedState($image),
            ), array(
                'background-image' => $this->getImageFileName($image, array(
                    'priority' => 9,
                )),
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

    protected function getImageSelectedState($image)
    {
        return array(
            'style_content' => array(
                'background-image' => $this->getImageFileName($image, array(
                    'priority' => 9,
                )),
                'background-size' => 'cover',
                'height' => '100',
                'width' => '100',
                'border-color' => '#fdca42',
                'border-width' => '4',
                'border-radius' => '4',
                'margin' => '0 5 0 5',
            ),
            'allow_unselect' => 1,
            'variable_value' => $this->getImageFileName($image, array(
                'priority' => 9,
                'imgwidth' => 2000,
                'imgheight' => 'auto',
            )),
        );
    }

    protected function sendEmailToPersonOnclick($action = 'Controller/email')
    {
        $onclick = $this->getOnclickRoute($action, false);

        $onclick[] = $this->getOnclickHideDiv('email');

        return $onclick;
    }
}