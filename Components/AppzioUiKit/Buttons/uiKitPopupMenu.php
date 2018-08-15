<?php

namespace Bootstrap\Components\AppzioUiKit\Buttons;

use Bootstrap\Components\BootstrapComponent;

trait uiKitPopupMenu
{
    public $isLiked;

    /**
     * @param array $items
     * @param array $parameters
     * @return mixed
     *
     * Example:
     *
     $btn[] = $this->components->uiKitPopupMenu([
        ['name' => '{#block_user#}','action' => $onclick],
            [
            'name' => '{#report_user#}',
            'div_id' => 'report_div',
            'div' => 'uiKitPopupMenuReportDiv',
            'div_parameters' =>
        ['items' => [
        '{#sexual_content#}',
        '{#offensive#}',
        '{#fake#}',
        '{#other#}'
        ],'action' => 'Controller/report/'.$id
        ]],
    ],['icon' => 'block-icon.png']);

     */
    public function uiKitPopupMenu($items = array(), $parameters = array())
    {

        $icon = isset($parameters['icon']) ? $parameters['icon'] : 'block-icon.png';

       foreach($items as $key=>$item){
            if(isset($item['div']) AND isset($item['div_parameters']) AND isset($item['div_id'])) {
                $id = $item['div_id'];
                $divs[$id] = array($item['div'], $item['div_parameters']);
            }
        }

        $divs['uikit-block-buttons'] = array('uiKitPopupButtonBlockDiv',$items);

        $this->addDivs($divs);

        $layout = new \stdClass();
        $layout->top = $this->screen_height / 12;
        $layout->right = $this->screen_width / 12;

        $onclick = $this->getOnclickShowDiv('uikit-block-buttons', array(
            'tap_to_close' => 1,
            'transition' => 'fade',
            'layout' => $layout
        ));

        return $this->getComponentRow(array(
            $this->getComponentImage($icon, array(
                'onclick' => $onclick,
                'style' => 'uikit_block_btn_icon'
            ))
        ), array(), array(
            'vertical-align' => 'middle'
        ));
    }

    public function uiKitPopupButtonBlockDiv($items){
        $buttons = array();

        foreach($items as $key=>$item){
            if(isset($item['div_id'])){
                $buttons[] = $this->uiKitPopupMenuItem(['text' => $item['name'],'divid' => $item['div_id']]);
            } elseif(isset($item['action'])) {
                $buttons[] = $this->uiKitPopupMenuItem(['text' => $item['name'],'action' => $item['action']]);
            }
            $buttons[] = $this->getComponentDivider();
        }

        array_pop($buttons);

        return $this->getComponentColumn($buttons, array(
            'style' => 'uikit_block_btn_div'
        ));

    }

    public function uiKitPopupMenuItem($parameters)
    {

        $text = isset($parameters['text']) ? $parameters['text'] : '{#report_user#}';
        $divId = isset($parameters['divid']) ? $parameters['divid'] : 'report_user';
        $action = isset($parameters['action']) ? $parameters['action'] : false;

        $layout = new \stdClass();
        $layout->top = 100;
        $layout->right = 10;
        $layout->left = 10;

        if($action){
            return $this->getComponentText($text, array(
                'onclick' => $action,
                'style' => 'uikit_block_btn_div_item_active'
            ));
        } else {
            return $this->getComponentText($text, array(
                'onclick' => $this->getOnclickShowDiv($divId, array(
                    'tap_to_close' => '1',
                    'background' => 'blur',
                    'transition' => 'from-bottom',
                    'layout' => $layout
                )),
                'style' => 'uikit_block_btn_div_item_active'
            ));
        }


    }


    public function uiKitPopupMenuReportDiv($parameters=array())
    {
        /** @var BootstrapComponent $this */

        $reasons = isset($parameters['items']) ? $parameters['items'] : array(
            '{#offensive_photos#}',
            '{#sexual_content#}',
            '{#fake_tattoo#}',
            '{#other_reason#}'
        );

        $action = isset($parameters['action']) ? $parameters['action'] : 'Default/report';

        $blockReasons = array();

        foreach ($reasons as $i => $reason) {

            $blockReasons[] = $this->uiKitPopupSingleReasonRow($reason);

            if (($i + 1) < count($reasons)) {
                $blockReasons[] = $this->getComponentDivider();
            }
        }

        return $this->getComponentColumn(array(
            $this->getComponentText('{#are_you_sure#}', array(
                'style' => 'uikit_div_popupmenu_title'
            )),
            $this->getComponentColumn($blockReasons),
            $this->getComponentText('{#please_chose_at_least_one_reason#}', array(
                'id' => 'error-message',
                'visibility' => 'hidden',
                'margin' => '5 0 5 0'
            ), array(
                'color' => '#ff0000',
                'width' => '100%',
                'padding' => '10 20 10 20',
                'text-align' => 'center'
            )),
            $this->getComponentText('Report', array(
                'parent_style' => 'uikit_div_popupmenu_button',
                'id' => 'show-error-button',
                'onclick' => array(
                    $this->getOnclickShowElement('error-message')
                )
            ),['background-color'=>$this->color_top_bar_color,'color' => $this->color_top_bar_text_color,
                'text-align' => 'center','width' => '100%','padding' => '20 0 20 0','font-weight' => 'bold']),
            $this->getComponentText('Report', array(
                'onclick' => array(
                    $this->getOnclickSubmit($action),
/*                    $this->getOnclickHideDiv('uikit-report-item'),
                    $this->getOnclickHideDiv('uikit-block-buttons'),*/
                    $this->getOnclickGoHome()
                ),
                'id' => 'submit-form-button',
                'visibility' => 'hidden',
            ),['background-color'=>$this->color_top_bar_color,'color' => $this->color_top_bar_text_color,
                'text-align' => 'center','width' => '100%','padding' => '20 0 20 0','font-weight' => 'bold'])
        ), array(
            'style' => 'uikit_popupmenu_div'
        ));
    }

    public function uiKitPopupSingleReasonRow($text)
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