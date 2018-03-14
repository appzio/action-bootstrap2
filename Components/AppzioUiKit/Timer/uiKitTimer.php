<?php

namespace Bootstrap\Components\AppzioUiKit\Timer;
use Bootstrap\Components\BootstrapComponent;

trait uiKitTimer{

    /**
     * @param array $parameters, array $styles
     * @return \stdClass
     */
    public function uiKitTimer($start_time, $default_time = 600, $disable_timer = false, array $parameters=array(),array $styles=array()) {
        /** @var BootstrapComponent $this */

        $options['mode'] = 'countdown';
        $options['style'] = 'uikit_timer';
        $options['timer_id'] = 'device-timer';
        $options['submit_menu_id'] = 'timer-expired';

        $current_time = time();
        $seconds_left = $default_time - ( $current_time - $start_time );
        
        if ( $disable_timer ) {
            $timer_output[] = $this->getComponentText('0', [], [
                'font-size' => '20',
                'color' => '#ffffff',
                'margin' => '0 0 0 0',
            ]);
        } else {
            $timer_output[] = $this->getTimer($seconds_left, $options);
        }

        $timer_output[] = $this->getComponentText(' sec', [], [
            'font-size' => '20',
            'color' => '#ffffff',
            'margin' => '0 0 0 0',
        ]);

        return $this->getComponentColumn([
            $this->getComponentRow($timer_output, [], [
                'vertical-align' => 'middle',
                'width' => 'auto',
                'text-align' => 'center',
            ])
        ], [], [
            'width' => 'auto',
            'height' => $this->screen_height / 3,
            'background-image' => $this->getImageFileName('uikit-timer-background.png'),
            'background-size' => 'contain',
            'vertical-align' => 'middle',
            'text-align' => 'center',
        ]);

    }

}