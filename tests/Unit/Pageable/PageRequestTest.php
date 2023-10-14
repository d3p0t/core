<?php

namespace D3p0t\Core\Tests\Unit\Pageable;

use D3p0t\Core\Pageable\PageRequest;
use D3p0t\Core\Pageable\Requests\PageableRequest;
use D3p0t\Core\Pageable\Requests\SortableRequest;
use D3p0t\Core\Pageable\SortRequest;
use D3p0t\Core\Tests\TestCase;

class PageRequestTest extends TestCase {

    public function testShouldMapEmptyPageRequest() {
        $request = new PageableRequest();

        $sut = PageRequest::fromRequest($request, new SortableRequest());

        $this->assertEquals($sut->perPage(), 20);
        $this->assertEquals($sut->pageNumber(), 0);
        $this->assertNotNull($sut->sortRequest());
    }

    public function testShouldMapPageRequest() {
        $request = new PageableRequest(['per_page' => 5, 'page_number' => 10]);

        $sut = PageRequest::fromRequest($request, new SortableRequest());

        $this->assertEquals($sut->perPage(), 5);
        $this->assertEquals($sut->pageNumber(), 10);
        $this->assertNotNull($sut->sortRequest());
    }
}
