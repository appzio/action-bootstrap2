<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;

trait uiKitBirthdayPickerDiv
{
    public $isLiked;

    public function uiKitBirthdayPickerDiv($params = array())
    {
        $closeDiv = new \stdClass();
        $closeDiv->action = 'hide-div';
        $closeDiv->keep_user_data = 1;

        /** @var BootstrapComponent $this */
        $title = isset($params['title']) ? $params['title'] : '{#select_birthdate#}';
        $subtitle = isset($params['subtitle']) ? $params['subtitle'] : '';
        $variable = isset($params['variable']) ? $params['variable'] : 'pick-date';

        return $this->getComponentColumn(array_merge(
            array(
                $this->getComponentRow(array(
                    $this->getComponentText($title, array(), array(
                        'color' => $this->color_top_bar_text_color,
                        'font-size' => '14',
                        'width' => '100%',
                    )),
                    $this->getComponentImage('cross-sign.png', array(
                        'onclick' => $closeDiv
                    ), array(
                        'width' => '15',
                        'floating' => '1',
                        'float' => 'right',
                        'margin' => '2 0 0 0'
                    ))
                ), array(), array(
                    'padding' => '10 20 10 20',
                    'background-color' => $this->color_top_bar_color,
                    'shadow-color' => '#33000000',
                    'shadow-radius' => '1',
                    'shadow-offset' => '0 3',
                    'margin' => '0 0 20 0'
                )),
                $this->getComponentSpacer(20),
                $this->getComponentFormFieldBirthday(
                array(
                    'width' => '100%',
                    'margin' => '5 15 0 15',
                )),
            ),
            $this->uikitBirthdayCalendarButtons( $params )
        ), array(), array(
            'background-color' => '#ffffff'
        ));
    }

    public function uikitBirthdayCalendarButtons( $params ) {

        $closeDiv = new \stdClass();
        $closeDiv->action = 'hide-div';
        $closeDiv->keep_user_data = 1;

        $actions[] = $closeDiv;
        $actions[] = $this->getOnclickSubmit('update_birthday',['viewport' => 'current']);

        $buttons = [];

        if ( isset($params['show_random']) AND $params['show_random'] == true ) {
            $buttons[] = $this->uiKitWideButton('{#random#}', array(
                'onclick' => [
                    $closeDiv,
                    $this->getOnclickSubmit( 'pick-random' )
                ]
            ), array(
                'parent_style' => 'uikit_wide_button_text_yellow',
                'background-color' => $this->color_top_bar_color,
                'color' => $this->color_top_bar_text_color
            ));
        }

        $buttons[] = $this->uiKitWideButton('{#select_date#}', array(
            'onclick' => $actions
        ));

        return $buttons;
    }

}

