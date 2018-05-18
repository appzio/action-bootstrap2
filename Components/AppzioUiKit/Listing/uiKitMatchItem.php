<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitMatchItem
{
    /**
     * @param array $content
     * @param array $parameters
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitMatchItem(array $content, array $parameters = array(), array $styles = array()) {
        /** @var BootstrapView $this */

        if ( !isset($content['name']) ) {
            return $this->getComponentText('{#missing_name#}');
        }

        if ( isset($content['profilepic']) AND $content['profilepic'] ) {
            $image = $content['profilepic'];
        } else {
            $image = 'uikit-profile-placeholder.png';
        }

        return $this->getComponentRow([
            $this->getComponentColumn([
                $this->getComponentImage($image, [], [
                    'width' => '100%',
                    'crop' => 'round',
                ])
            ], [], [
               'width' => '15%',
            ]),
            $this->getComponentColumn($this->uiKitMatchItemContent( $content ), [], [
                'width' => '85%',
                'padding' => '0 0 0 15',
            ]),
        ], $parameters, [
            'width' => 'auto',
            'margin' => '5 15 5 15',
        ]);
    }

    private function uiKitMatchItemContent( $content ) {

        $top_row[] = $this->getComponentText($content['name'], [], [
            'color' => '#311816',
            'font-size' => '16',
            'margin' => '0 0 0 0',
        ]);

        if ( isset($content['chat_data']['message']) AND $chat_data = $content['chat_data'] ) {

            $top_row_data = [];

            if ( $chat_data['is_message_read'] != '1' ) {
                $top_row_data[] = $this->getComponentText(' ', [] , [
                    'width' => '12',
                    'height' => '12',
                    'border-radius' => '6',
                    'background-color' => '#d51f1f',
                    'margin' => '0 5 0 0',
                ]);
            }

            $format = 'h:i';
            $stamp = strtotime($chat_data['timestamp']);
            
            if ( time() - $stamp > 86400  ) {
                $format = 'd.m';
            }

            $time = date($format, $stamp);

            $top_row_data[] = $this->getComponentText($time, [], [
                'color' => '#9b9b9b',
                'font-size' => '13',
            ]);
            
            $top_row[] = $this->getComponentColumn([
                $this->getComponentRow($top_row_data, [], [
                    'vertical-align' => 'middle',
                ])
            ], [], [
                'floating' => 1,
                'float' => 'right',
                'text-align' => 'right',
                'vertical-align' => 'middle',
            ]);
        }

        $bottom_row = [];

        if ( isset($chat_data['message']) ) {
            $bottom_row[] = $this->getComponentText($chat_data['message'], [], [
                'color' => '#6b7175',
                'font-size' => '14',
                'margin' => '5 0 0 0',
                'font-weight' => ( $chat_data['is_message_read'] != '1' ? 'bold' : 'normal' ),
            ]);
        } else if ( isset($content['profile_comment']) AND $content['profile_comment'] ) {
            $bottom_row[] = $this->getComponentText($content['profile_comment'], [], [
                'color' => '#6b7175',
                'font-size' => '14',
                'margin' => '5 0 0 0',
            ]);
        }

        return [
            $this->getComponentRow($top_row),
            $this->getComponentRow($bottom_row),
        ];
    }

}