<?php

namespace Bootstrap\Components\AppzioUiKit\Chat;

trait uiKitChatMessageUser {

    public function uiKitChatMessageUser(array $message, $parameters=array(), $styles=array()){
        $data = [];

        if ( !empty($message['msg']) ) {
            $data[] = $this->getComponentText($message['msg'], [], [
                'padding' => '12 12 12 12',
                'font-size' => '14',
                'font-style' => 'normal',
                'color' => '#676d77',
                'vertical-align' => 'middle'
            ]);
        }

        if ( isset($message['attachment']) ) {
            $data[] = $this->uiKitChatMessageAttachment( $message['attachment'] );
        }

        return $this->getComponentRow([
            $this->getComponentColumn([
                $this->getComponentImage($this->uiKitChatMessagePic( $message ), [], [
                    'crop' => 'round'
                ])
            ], [], [
                'width' => '10%',
                'margin' => '0 10 0 0',
            ]),
            $this->getComponentColumn($data, [], [
                'width' => $this->uiKitChatMessageWidth( $message ),
                'vertical-align' => 'middle',
                'text-align' => 'left',
                'background-color' => '#f9f9f9',
                'border-radius' => '8',
                'color' => '#676d77',
            ])
        ], [], [
            'width' => '100%',
            'text-align' => 'left',
            'margin' => '0 10 0 10',
            'vertical-align' => 'middle'
        ]);
    }

}