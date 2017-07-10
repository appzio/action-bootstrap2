<?php

namespace Bootstrap\Components\Elements;
use Bootstrap\Views\BootstrapView;

trait InfiniteScroll {

    /**
     * @param $content array of objects, similar to row or column
     * @param $nextpageid string, this is the id that client will send to server when user reaches the end of the scroll
     * @return \stdClass
     */

    public function getComponentInfiniteScroll(array $content, string $nextpageid) {
        /** @var BootstrapView $this */

		$obj = new \StdClass;
        $obj->type = 'infinite-scroll';
        $obj->content = $content;
        $obj->next_page_id = $nextpageid;

        return $obj;
	}

}