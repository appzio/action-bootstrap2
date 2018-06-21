<?php

namespace Bootstrap\Components\AppzioUiKit\Chat;

trait uiKitChatMessageUser {

    public function uiKitChatMessageUser(array $message, $parameters=array(), $styles=array()){
        $data = [];

        $attachment_width = 'auto';

        if ( !empty($message['msg']) ) {
            $data[] = $this->getComponentText($message['msg'], [], [
                'padding' => '12 12 12 12',
                'font-size' => '14',
                'font-style' => 'normal',
                'color' => '#676d77',
                'vertical-align' => 'middle'
            ]);

            $attachment_width = '100%';
        }

        if ( isset($message['attachment']) ) {
            $data[] = $this->uiKitChatMessageAttachment( $message['attachment'], $attachment_width );
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
            $this->getComponentColumn($data, [], array_merge(
                array(
                    'vertical-align' => 'middle',
                    'text-align' => 'left',
                    'background-color' => '#f9f9f9',
                    'border-radius' => '8',
                    'color' => '#676d77',
                ),
                $this->uiKitChatMessageWidth( $message, 'right' )
            ))
        ], [], [
            'width' => '100%',
            'text-align' => 'left',
            'padding' => '0 10 0 10',
            'vertical-align' => 'top'
        ]);
    }

}