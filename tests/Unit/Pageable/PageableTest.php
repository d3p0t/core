<?php

namespace D3p0t\Core\Tests\Unit\Pageable;

use D3p0t\Core\Pageable\Pageable;
use D3p0t\Core\Pageable\PageRequest;
use D3p0t\Core\Pageable\Requests\PageableRequest;
use D3p0t\Core\Pageable\Requests\SortableRequest;
use D3p0t\Core\Pageable\SortRequest;
use D3p0t\Core\Tests\TestCase;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Mockery\MockInterface;

class PageableTest extends TestCase {

    public function testEmptyPageableMapping() {
        $request = PageRequest::fromRequest(new PageableRequest(), new SortableRequest());

        $paginator = $this->mock(LengthAwarePaginator::class, function (MockInterface $mock) {
            $mock->shouldReceive('items')->andReturn([]);
            $mock->shouldReceive('total')->andReturn(0);
            $mock->shouldReceive('perPage')->andReturn(10);
        });

        $sut = new Pageable($request, $paginator);

        $this->assertEquals($sut->totalPages(), 0);
        $this->assertEquals($sut->items(), []);
        $this->assertEquals($sut->totalItems(), 0);
        $this->assertTrue($sut->first());
        $this->assertTrue($sut->last());

    }

    public function testSinglePagePageableMapping() {
        $request = PageRequest::fromRequest(new PageableRequest(), new SortableRequest());

        $paginator = $this->mock(LengthAwarePaginator::class, function (MockInterface $mock) {
            $mock->shouldReceive('items')->andReturn([]);
            $mock->shouldReceive('total')->andReturn(1);
            $mock->shouldReceive('perPage')->andReturn(10);
        });

        $sut = new Pageable($request, $paginator);

        $this->assertEquals($sut->totalPages(), 1);
        $this->assertEquals($sut->items(), []);
        $this->assertEquals($sut->totalItems(), 1);
        $this->assertTrue($sut->first());
        $this->assertTrue($sut->last());
    }

    public function testMultiPagePageableMapping() {
        $request = PageRequest::fromRequest(new PageableRequest(), new SortableRequest());

        $paginator = $this->mock(LengthAwarePaginator::class, function (MockInterface $mock) {
            $mock->shouldReceive('items')->andReturn([]);
            $mock->shouldReceive('total')->andReturn(10);
            $mock->shouldReceive('perPage')->andReturn(5);
        });

        $sut = new Pageable($request, $paginator);

        $this->assertEquals($sut->totalPages(), 2);
        $this->assertEquals($sut->items(), []);
        $this->assertEquals($sut->totalItems(), 10);
        $this->assertTrue($sut->first());
        $this->assertFalse($sut->last());
    }
}
