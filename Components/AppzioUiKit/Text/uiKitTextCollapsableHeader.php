<?php

namespace Bootstrap\Components\AppzioUiKit\Text;
use Bootstrap\Views\BootstrapView;

trait uiKitTextCollapsableHeader {

    /**
     * @param $subject string, no support for line feeds
     * @param $headertext string, supports line feeds
     * @param array $parameters selected_state, variable, onclick, style
     * <code>
     * $array = array(
     * 'selected_state' => 'style-class-name',
     * 'variable'   => 'variablename',
     * 'uppercase' => '1' // transform to uppercase
     * 'onclick' => $onclick, // this must be an object or an array of objects
     * 'style' => 'style-class-name',
     * );
     * </code>
     * @param array $styles
     * <code>
     * $array = array(
     * 'margin' => '0 0 0 0',
     * 'padding' => '0 0 0 0',
     * 'width' => '200', // or 100%
     * 'height' => '400',
     * 'max_height' => '500',
     * 'background-color' => '#ffffff',
     * 'background-image' => 'filename.png',
     * 'background-size' => 'cover', // or 'contain', 'top' (default)
     * 'crop' => 'round', // or 'yes'
     * 'vertical-align' => 'middle',
     * 'text-align' => 'center',
     * 'font-size' => '14',
     * 'font-ios' => 'Roboto',
     * 'font-weight' => 'Bold',
     * 'font-style' => 'Italic',
     * 'font-android' => 'Roboto',
     * 'color' => '#000000',
     * 'white-space' => 'nowrap',
     * 'children_style' => 'style-class-name' // this is used only in menu, progress and field-list components
     * 'floating' => '1',
     * 'float' => 'right',
     * 'parent_style' => 'style-class-name',
     * 'shadow-color' => '#000000',
     * 'shadow-offset' => '0 1',
     * 'shadow-radius' => '5',
     * 'border-width' => '1',
     * 'border-color' => '#000000',
     * 'border-radius' => '4',
     * 'opacity' => '0.4',
     * );
     * </code>
     * @return \stdClass
     */

    public function uiKitCollabpsableTextHeader(string $subject,string $headertext, array $parameters=array(),array $styles=array())
    {
        /** @var BootstrapView $this */

        $headertext = trim($headertext, "\t\n\r\0\x0B");

        if (strlen($headertext) > 300) {
            $short_header = substr($headertext, 0, strpos($headertext, ' ', 110));
        } else {
            $short_header = $headertext;
        }

        $col[] = $this->getComponentText($subject, [], [
            'font-size' => '24', 'color' => $this->color_top_bar_color, 'margin' => '20 20 0 20']);

        if (strlen($headertext) > 300) {
            $col[] = $this->getComponentText($short_header . '...', ['id' => 'uikch_header_collapsed'],
                ['font-size' => '14','margin' => '20 20 0 20']);

            $onclick[] = $this->getOnclickHideElement('uikch_header_collapsed', ['transition' => 'none']);
            $onclick[] = $this->getOnclickHideElement('uikch_show_more', ['transition' => 'none']);
            $onclick[] = $this->getOnclickShowElement('uikch_header_expanded', ['transition' => 'none']);
            $onclick[] = $this->getOnclickShowElement('uikch_show_less', ['transition' => 'none']);

            $onclick2[] = $this->getOnclickHideElement('uikch_header_expanded', ['transition' => 'none']);
            $onclick2[] = $this->getOnclickHideElement('uikch_show_less', ['transition' => 'none']);
            $onclick2[] = $this->getOnclickShowElement('uikch_header_collapsed', ['transition' => 'none']);
            $onclick2[] = $this->getOnclickShowElement('uikch_show_more', ['transition' => 'none']);

            /* initially visible */
            $col[] = $this->getComponentText($headertext, ['id' => 'uikch_header_expanded', 'visibility' => 'hidden'],
                ['margin' => '20 20 0 20','font-size' => '14','color' => $this->color_text_color]);

            $row[] = $this->getComponentImage('icon-plus.png',[],['width' => '20','margin' => '0 5 0 0']);
            $row[] = $this->getComponentText('{#read_more#}',
                [],
                ['color' => $this->color_top_bar_color]);

            $col[] = $this->getComponentRow($row,['onclick' => $onclick, 'id' => 'uikch_show_more'],['margin' => '20 20 20 20']);

            /* hidden part */
            $row2[] = $this->getComponentImage('icon-minus.png',[],['width' => '20','margin' => '0 5 0 0']);
            $row2[] = $this->getComponentText('{#collapse_header#}',
                [],
                ['color' => $this->color_top_bar_color]);

            $col[] = $this->getComponentRow($row2,['onclick' => $onclick2, 'id' => 'uikch_show_less','visibility'=>'hidden'],
                ['margin' => '20 20 20 20']);

        } else {
            $col[] = $this->getComponentText($headertext,[],['color' => $this->color_text_color,'margin' => '15 15 15 15']);
        }

        return $this->getComponentColumn($col);
    }

}