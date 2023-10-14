<?php

namespace D3p0t\Core\Tests\Unit\Pageable;

use D3p0t\Core\Pageable\Requests\SortableRequest;
use D3p0t\Core\Pageable\SortRequest;
use D3p0t\Core\Tests\TestCase;

class SortRequestTest extends TestCase {

    public function testShouldMapEmptySortRequest() {
        $request = new SortableRequest();

        $sut = SortRequest::fromRequest($request);

        $this->assertEquals($sut->sortBy(), 'id');
        $this->assertEquals($sut->sortDirection(), 'asc');
    }

    public function testShouldMapSortRequest() {
        $request = new SortableRequest(['sort_direction' => 'desc', 'sort_by' => 'name']);

        $sut = SortRequest::fromRequest($request);

        $this->assertEquals($sut->sortBy(), 'name');
        $this->assertEquals($sut->sortDirection(), 'desc');
    }
}