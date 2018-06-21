<?php

namespace Bootstrap\Components\AppzioUiKit\Chat;

trait uiKitChatMessageOwner {

    public function uiKitChatMessageOwner(array $message, $parameters=array(), $styles=array()){
        $data = [];

        $attachment_width = 'auto';

        if ( !empty($message['msg']) ) {
            $data[] = $this->getComponentText($message['msg'], [], [
                'padding' => '12 12 12 12',
                'text-align' => 'right',
                'font-size' => '14',
                'font-style' => 'normal',
                'color' => '#ffffff',
                'vertical-align' => 'middle'
            ]);

            $attachment_width = '100%';
        }

        if ( isset($message['attachment']) ) {
            $data[] = $this->uiKitChatMessageAttachment( $message['attachment'], $attachment_width );
        }

        return $this->getComponentRow([
            $this->getComponentColumn([
            ], [], [
                'width' => '15',
                'margin' => '0 0 0 20',
            ]),
            $this->getComponentColumn($data, [], array_merge(
                array(
                    'vertical-align' => 'middle',
                    'text-align' => 'right',
                    'background-color' => '#4678ff',
                    'border-radius' => '8',
                    'color' => '#ffffff',
                ),
                $this->uiKitChatMessageWidth( $message, 'left' )
            )),
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
            'padding' => '0 10 0 10',
            'vertical-align' => 'top',
        ]);
    }

    public function uiKitChatMessagePic( $message ) {

        if ( !isset($message['profilepic']) ) {
            return 'uikit-profile-placeholder.png';
        }

        return $message['profilepic'];
    }

    public function uiKitChatMessageAttachment( $attachment, $width ) {

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
            'width' => $width,
            'border-radius' => 8,
            'margin' => '4 4 4 4',
        ]);
    }

    public function uiKitChatMessageWidth( $message, $offset ) {

        if ( isset($message['attachment']) AND empty($message['msg']) ) {
            return [
                'width' => 'default'
            ];
        } else if ( isset($message['attachment']) AND !empty($message['msg']) AND $offset == 'right' ) {
            return [
                'margin' => '0 0 0 0'
            ];
        }

        return [
            'margin' => ( $offset == 'left' ? '0 0 0 15' : '0 0 0 0' )
        ];
    }

}