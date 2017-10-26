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
            $this->getComponentText('Report', array(
                'style' => 'uikit_div_button',
                'onclick' => array(
                    $this->getOnclickSubmit('Reporting/default'),
                    $this->getOnclickHideDiv('report-item'),
                    $this->getOnclickHideDiv('block-buttons'),
                    $this->getOnclickGoHome()
                )
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
                'style' => 'uikit_report_item_div_checkbox'
            ))
        ));
    }
}