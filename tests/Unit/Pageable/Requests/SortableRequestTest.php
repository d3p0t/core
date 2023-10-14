<?php

namespace D3p0t\Core\Test\Unit\Pageable\Requests;

use D3p0t\Core\Pageable\Requests\SortableRequest;
use D3p0t\Core\Tests\TestCase;
use Validator;

class SortableRequestTest extends TestCase {

    public function testShouldMapEmptySortableRequest() {
        $sut = new SortableRequest();

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->invokeMethod($sut, 'prepareForValidation');

        $this->assertTrue($validator->passes());

        $this->assertEquals($sut->query('sort_direction'), 'asc');
        $this->assertEquals($sut->query('sort_by'), 'id');        
    }

    public function testShouldMapSortableRequest() {
        $sut = new SortableRequest(['sort_direction' => 'desc', 'sort_by' => 'name']);

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->invokeMethod($sut, 'prepareForValidation');

        $this->assertTrue($validator->passes());

        $this->assertEquals($sut->query('sort_direction'), 'desc');
        $this->assertEquals($sut->query('sort_by'), 'name');        
    }

    public function testShouldThrowValidationExceptionOnInvalidSortDirection() {
        $sut = new SortableRequest(['sort_direction' => 'ERROR' ]);

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->assertFalse($validator->passes());

        $this->assertEquals($validator->errors()->first('sort_direction'), 'The selected sort direction is invalid.');
    }

    public function testShouldThrowValidationExceptionOnInvalidSortBy() {
        $sut = new SortableRequest(['sort_by' => false ]);

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->assertFalse($validator->passes());

        $this->assertEquals($validator->errors()->first('sort_by'), 'The sort by field must be a string.');
    }
}
