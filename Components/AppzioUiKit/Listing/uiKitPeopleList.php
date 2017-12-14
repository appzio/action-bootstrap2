<?php

namespace Bootstrap\Components\AppzioUiKit\Listing;
use Bootstrap\Views\BootstrapView;

trait uiKitPeopleList
{
    /**
     * @param array $people
     * array(
     *     0 => array(
     *         'name' - the name of the person - required,
     *         'info' - additional information - required,
     *         'contact' - contact information for the person - required,
     *         'onclick' - action to be executed on row click - required
     *     )
     * )
     * @param array $params
     * @param array $styles
     * @return \stdClass
     */
    public function uiKitPeopleList(array $people, array $params = array(), array $styles = array())
    {
        /** @var BootstrapView $this */
        $page = isset($_REQUEST['next_page_id']) ? $_REQUEST['next_page_id'] : 1;

        $items = array();

        foreach ($people as $item) {
            $items[] = $this->getPersonRow($item);
            $items[] = $this->uiKitDivider();
        }

        return $this->getInfiniteScroll($items, array('next_page_id' => (int)$page + 1));
    }

    protected function getPersonRow($person)
    {
        $divLayout = new \stdClass();
        $divLayout->top = 80;
        $divLayout->bottom = 0;
        $divLayout->left = 0;
        $divLayout->right = 0;

        /** @var BootstrapView $this */
        return $this->getComponentRow(array(
            $this->getComponentColumn(array(
                $this->getPersonName($person['name']),
                $this->getPersonInfo($person['info']),
                $this->getPersonContact($person['contact'])
            ))
        ), array(
            'style' => 'uikit_people_list_person_wrapper',
            'onclick' => $this->getOnclickShowDiv('email', array(
                'background' => 'blur',
                'tap_to_close' => 1,
                'transition' => 'from-bottom',
                'layout' => $divLayout
            ))
        ));
    }

    protected function getPersonName($name)
    {
        return $this->getComponentText($name, array(
            'style' => 'uikit_people_list_person_name'
        ));
    }

    protected function getPersonInfo($info)
    {
        return $this->getComponentText(strtoupper($info), array(
            'style' => 'uikit_people_list_person_info'
        ));
    }

    protected function getPersonContact($contact)
    {
        return $this->getComponentText($contact, array(
            'style' => 'uikit_people_list_person_contact'
        ));
    }
}