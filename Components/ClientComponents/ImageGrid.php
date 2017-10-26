<?php

namespace Bootstrap\Components\ClientComponents;

use Bootstrap\Components\BootstrapComponent;

trait ImageGrid
{


    private $deleting = false;
    private $margin;
    private $grid;

    /**
     * @param $options array 'variable'
     * @param array $styles 'margin', 'padding', 'orientation', 'background', 'alignment', 'radius', 'opacity',
     * 'orientation', 'height', 'width', 'align', 'crop', 'text-style', 'font-size', 'text-color', 'border-color',
     * 'border-width', 'font-android', 'font-ios', 'background-color', 'background-image', 'background-size',
     * 'color', 'shadow-color', 'shadow-offset', 'shadow-radius', 'vertical-align', 'border-radius', 'text-align',
     * 'lazy', 'floating' (1), 'float' (right | left), 'max-height', 'white-space' (no-wrap), parent_style
     * @param array $parameters selected_state, variable, onclick, style
     * @return array
     */

    public function getComponentImageGrid($options = array(), $styles = array(), $parameters = array())
    {
        $variable  = $options['base_variable'];

        /** @var BootstrapComponent $this */
        $width = $this->screen_width ? $this->screen_width : 320;
        $this->margin = 20;
        $this->grid = $width - ($this->margin * 4);
        $this->grid = round($this->grid / 3, 0);

        $column[] = $this->getComponentRow(array(
            $this->getProfileImage($variable, true),
        ), array(), array(
            'width' => '65%'
        ));

        $column[] = $this->getComponentVerticalSpacer($this->margin);

        $row[] = $this->getProfileImage($variable . '2');
        $row[] = $this->getComponentSpacer($this->margin);
        $row[] = $this->getProfileImage($variable . '3');

        $column[] = $this->getComponentColumn($row);

        $response[] = $this->getComponentRow($column, array(), array('margin' => '0 ' . $this->margin . ' 0 ' . $this->margin));
        $response[] = $this->getComponentSpacer($this->margin);

        unset($column);
        unset($row);

        $column[] = $this->getProfileImage($variable . '4');
        $column[] = $this->getComponentVerticalSpacer($this->margin);
        $column[] = $this->getProfileImage($variable . '5');
        $column[] = $this->getComponentVerticalSpacer($this->margin);
        $column[] = $this->getProfileImage($variable . '6');

        $response[] = $this->getComponentRow($column, array(), array('margin' => '0 ' . $this->margin . ' 0 ' . $this->margin));

        return $this->getComponentColumn($response,array(),array('margin' => '0 0 0 0'));
    }

    public function setGridWidths()
    {
        $width = $this->screen_width ? $this->screen_width : 320;
        $this->margin = 20;
        $this->grid = $width - ($this->margin * 4);
        $this->grid = round($this->grid / 3, 0);
    }

    public function getProfileImage($name, $mainimage = false)
    {
        /** @var BootstrapComponent $this */
        if ($mainimage) {
            $params['width'] = $this->grid * 2 + $this->margin;
            $params['height'] = $this->grid * 2 + $this->margin;
        } else {
            $params['width'] = $this->grid;
            $params['height'] = $this->grid;
        }

        $params['imgwidth'] = '300';
        $params['imgheight'] = '300';
        $params['imgcrop'] = 'yes';
        $params['crop'] = (isset($crop) ? $crop : 'yes');

        if ($this->deleting AND $this->model->getSavedVariable($name) AND strlen($this->model->getSavedVariable($name)) > 2) {
            $params['opacity'] = '0.6';
            $onclick = new \StdClass();
            $onclick->action = 'submit-form-content';
        } else {
            $onclick = new \StdClass();
            $onclick->action = 'upload-image';
            $onclick->max_dimensions = '1200';
            $onclick->variable = $this->model->getVariableId($name);
            $onclick->action_config = $this->model->getVariableId($name);
        }

        return $this->getComponentImage($this->model->getSavedVariable($name), array(
            'defaultimage' => 'formkit-photo-placeholder.png',
            'onclick' => $onclick,
            'use_variable' => true,
            'variable' => $this->model->getVariableId($name),
            'config' => $this->model->getVariableId($name),
            'debug' => 1,
            'priority' => 9
        ), $params);
    }
}
