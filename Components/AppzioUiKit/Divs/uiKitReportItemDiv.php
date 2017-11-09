<?php

namespace Bootstrap\Components\AppzioUiKit\Divs;

use Bootstrap\Components\BootstrapComponent;

trait uiKitReportItemDiv
{
    public function uiKitReportItemDiv()
    {
        /** @var BootstrapComponent $this */

        $reasons = array(
            '{#offensive_photos#}',
            '{#sexual_content#}',
            '{#fake_tattoo#}',
            '{#other_reason#}'
        );

        $blockReasons = array();

        foreach ($reasons as $i => $reason) {

            $blockReasons[] = $this->getSingleReasonRow($reason);

            if (($i + 1) < count($reasons)) {
                $blockReasons[] = $this->getComponentDivider();
            }
        }

        return $this->getComponentColumn(array(
            $this->getComponentText('Are you sure?', array(
                'style' => 'uikit_div_title'
            )),
            $this->getComponentColumn($blockReasons),
            $this->getComponentText('{#please_chose_at_least_one_reason#}', array(
                'id' => 'error-message',
                'visibility' => 'hidden',
                'margin' => '5 0 5 0'
            ), array(
                'color' => '#ff0000',
                'text-align' => 'center'
            )),
            $this->getComponentText('Report', array(
                'style' => 'uikit_div_button',
                'id' => 'show-error-button',
                'onclick' => array(
                    $this->getOnclickShowElement('error-message')
                )
            )),
            $this->getComponentText('Report', array(
                'style' => 'uikit_div_button',
                'onclick' => array(
                    $this->getOnclickSubmit('Reporting/default'),
                    $this->getOnclickHideDiv('uikit-report-item'),
                    $this->getOnclickHideDiv('uikit-block-buttons'),
                    $this->getOnclickGoHome()
                ),
                'id' => 'submit-form-button',
                'visibility' => 'hidden',
            ))
        ), array(
            'style' => 'uikit_div'
        ));
    }

    protected function getSingleReasonRow($text)
    {
        return $this->getComponentRow(array(
            $this->getComponentText($text, array(
                'style' => 'uikit_report_item_div_reason'
            )),
            $this->getComponentFormFieldOnoff(array(
                'variable' => $text,
                'style' => 'uikit_report_item_div_checkbox',
                'onclick' => array(
                    $this->getOnclickShowElement('submit-form-button', array(
                        'transition' => 'none'
                    )),
                    $this->getOnclickHideElement('show-error-button', array(
                        'transition' => 'none'
                    )),
                    $this->getOnclickHideElement('error-message', array(
                        'transition' => 'none'
                    ))
                )
            ))
        ));
    }
}