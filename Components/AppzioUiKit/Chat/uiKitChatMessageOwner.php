<?php

namespace Bootstrap\Components\AppzioUiKit\Chat;

trait uiKitChatMessageOwner {

    public function uiKitChatMessageOwner(array $message, $parameters=array(), $styles=array()){
        $data = [];

        if ( !empty($message['msg']) ) {
            $data[] = $this->getComponentText($message['msg'], [], [
                'padding' => '12 12 12 12',
                'font-size' => '14',
                'font-style' => 'normal',
                'color' => '#ffffff',
                'vertical-align' => 'middle'
            ]);
        }

        if ( isset($message['attachment']) ) {
            $data[] = $this->uiKitChatMessageAttachment( $message['attachment'] );
        }

        return $this->getComponentRow([
            $this->getComponentColumn($data, [], [
                'width' => $this->uiKitChatMessageWidth( $message ),
                'vertical-align' => 'middle',
                'text-align' => 'right',
                'background-color' => '#4678ff',
                'border-radius' => '8',
                'color' => '#ffffff',
            ]),
            $this->getComponentColumn([
                $this->getComponentImage($this->uiKitChatMessagePic( $message ), [], [
                    'crop' => 'round'
                ])
            ], [], [
                'width' => '10%',
                'margin' => '0 0 0 10',
            ])
        ], [], [
            'width' => '100%',
            'text-align' => 'right',
            'margin' => '0 10 0 10',
            'vertical-align' => 'top',
        ]);
    }

    public function uiKitChatMessagePic( $message ) {

        if ( !isset($message['profilepic']) ) {
            return 'uikit-profile-placeholder.png';
        }

        return $message['profilepic'];
    }

    public function uiKitChatMessageAttachment( $attachment ) {

        $image = $this->getComponentImage($attachment, [
            'imgwidth' => '900',
            'imgheight' => '900',
            'priority' => 9,
        ]);

        $img_params = array(
            'imgwidth' => 300,
            'imgheight' => 300,
            'priority' => 9,
            'tap_to_open' => 1,
            'tap_image' => '',
        );

        if ( isset($image->content) ) {
            $bigimage = $image->content;
            $img_params['tap_image'] = $bigimage;
        }

        return $this->getComponentImage($attachment, $img_params, [
            'width' => 'auto',
            'border-radius' => 8,
            'margin' => '4 4 4 4',
        ]);
    }

    public function uiKitChatMessageWidth( $message ) {

        if ( isset($message['attachment']) AND empty($message['msg']) ) {
            return 'default';
        }

        if ( $message['msg'] ) {
            $length = strlen($message['msg']);

            if ( $length < 10 ) {
                return '40%';
            } else if ( $length > 100 ) {
                return '70%';
            }
        }

        return 'auto';
    }

}