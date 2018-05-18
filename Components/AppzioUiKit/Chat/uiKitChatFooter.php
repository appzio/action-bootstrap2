<?php

namespace Bootstrap\Components\AppzioUiKit\Chat;

trait uiKitChatFooter {

    public function uiKitChatFooter($parameters=array(), $styles=array()){
        $data[] = $this->uiKitChatFooterUpload();
        $data[] = $this->getComponentVerticalSpacer(5);
        $data[] = $this->getComponentColumn([
            $this->getComponentFormFieldTextArea('', [
                'submit_menu_id' => 'submit-msg',
                'hint' => '{#type_to_send#} ...',
                'variable' => 'tmp-chat-message',
                'value' => '',
                'activation' => 'keep-open',
            ], [
                'background-color' => '#ffffff',
                'font-size' => '13',
                'font-style' => 'italic',
                'color' => '#474747',
                'padding' => '10 4 10 4',
                'vertical-align' => 'middle',
                'height' => '50',
            ]),
        ], [], [
            'width' => '70%',
            'vertical-align' => 'middle'
        ]);

        $data[] = $this->getComponentImage('uikit-chat-invisible-divider.png', [
            'variable' => $this->model->getVariableId('chat_upload_temp')
        ], [
            'width' => '25',
            'max-height' => '25',
            'margin' => '0 0 0 5',
        ]);

        $data[] = $this->uiKitChatFooterSubmit();

        return $this->getComponentRow($data, [], [
            'background-color' => '#ffffff',
            'padding' => '10 15 10 15',
            'vertical-align' => 'middle',
        ]);
    }

    protected function uiKitChatFooterUpload() {

        $onclick = $this->getOnclickImageUpload('chat_upload_temp', [
            'sync_upload' => 1,
            'viewport' => 'bottom',
            'max_dimensions' => '600',
            'allow_delete' => true,
        ]);

        if ( $this->model->getConfigParam('actionimage5') ) {
            return $this->uiKitChatFooterImagebutton( $this->model->getConfigParam('actionimage5'), $onclick);
        } else {
            return $this->uiKitChatFooterImagebutton( 'uikit-chat-icon-send-image.png', $onclick);
        }
    }

    protected function uiKitChatFooterImagebutton($icon, $onclick){
        return $this->getComponentImage($icon, [
            'onclick' => $onclick,
        ], [
            'width' => '25',
            'height' => '25',
        ]);
    }

    protected function uiKitChatFooterSubmit(){

        $onclick = $this->getOnclickRoute(
            'Chat/SaveMessage',
            false,
            [],
            true,
            [
                'viewport' => 'bottom',
            ]
        );

        if($this->model->getConfigParam('actionimage4')){
            $btn = $this->model->getConfigParam('actionimage4');
            $button_obj = $this->uiKitChatFooterImagebutton($btn, $onclick);
        } else {
            $btn = 'uikit-chat-icon-send-msg.png';
            $button_obj = $this->uiKitChatFooterImagebutton($btn, $onclick);
        }

        return $this->getComponentColumn([
            $button_obj
        ], [], [
            'floating' => 1,
            'float' => 'right',
            'vertical-align' => 'middle',
        ]);
    }

}