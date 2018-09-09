<?php

namespace Bootstrap\Components\AppzioUiKit\Forms;
use Bootstrap\Components\BootstrapComponent;

trait uiKitRadioButtonsCheckboxes {

    public function uiKitRadioButtonsCheckboxes( $items, $variable, $current_val, $type = 'radio' ) {

        if ( empty($items) ) {
            return false;
        }

        $active_values = array( $current_val );

        if ( $type == 'checkboxes' ) {
            $active_values = @json_decode( $current_val, true );
        }

        foreach ($items as $item) {
            $left_col = $this->getComponentText( $item, [],array( 'font-size' => '14' ) );

            $selectstate = array(
                'style' => 'uikit_quiz_selected',
                'variable_value' => $item,
                'allow_unselect' => 1,
                'animation' => 'fade'
            );

            if ( !empty($current_val) AND in_array($item, $active_values) ) {
                $selectstate['active'] = '1';
            }

            $right_col = $this->getComponentText('', array(
                'variable' => ( $type == 'radio' ? $variable : $variable . '_' . $item ),
                'variable_value' => $item,
                'style' => 'uikit_quiz_unselected',
                'allow_unselect' => 1,
                'selected_state' => $selectstate,
            ));

            $col[] = $this->getComponentRow(array(
                $left_col, $right_col
            ), [], array( 'padding' => '5 0 5 0', 'margin' => '4 0 4 0' ));
        }

        return $this->getComponentColumn($col,[],['margin' => '10 0 0 0']);

    }

}