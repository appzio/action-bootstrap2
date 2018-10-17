<?php

namespace Bootstrap\Components\AppzioUiKit\Text;

trait uiKitTermsText
{

    public function uiKitTermsText(array $params=array())
    {

        $action = isset($params['actionid']) ? $params['actionid'] : 0;
        $text = isset($params['text']) ? $params['text'] : '{#by_registering_or_logging_in_you_agree_to_the#}';
        $link_text = isset($params['link_text']) ? $params['link_text'] : '{#terms_and_conditions#}';

        $onclick = new \StdClass();
        $onclick->action = 'open-action';
        $onclick->action_config = $action;
        $onclick->open_popup = '1';

        return $this->getComponentColumn(array(
            $this->getComponentText($text, [],array(
                'text-align' => 'center',
                'font-size' => '12',
                'color' => $this->color_text_color,
                'margin' => '0 0 5 0'
            )),
            $this->getComponentText($link_text, array(
                'onclick' => $onclick
            ),[
                'text-align' => 'center',
                'font-size' => '12',
                'font-weight' => 'bold',
                'color' => $this->color_text_color
            ])
        ),[], array(
            'text-align' => 'center',
            'margin' => '0 0 10 0',
            'width' => '100%'
        ));
    }


}