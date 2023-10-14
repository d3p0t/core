<?php

namespace D3p0t\Core\Test\Unit\Pageable\Requests;

use D3p0t\Core\Pageable\Requests\PageableRequest;
use D3p0t\Core\Tests\TestCase;
use Validator;

class PageableRequestTest extends TestCase {

    public function testShouldMapEmptyPageableRequest() {
        $sut = new PageableRequest();

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->invokeMethod($sut, 'prepareForValidation');

        $this->assertTrue($validator->passes());

        $this->assertEquals($sut->query('per_page'), 20);
        $this->assertEquals($sut->query('page_number'), 0);        
    }

    public function testShouldMapPageableRequest() {
        $sut = new PageableRequest(['per_page' => 5, 'page_number' => 10]);

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->invokeMethod($sut, 'prepareForValidation');

        $this->assertTrue($validator->passes());

        $this->assertEquals($sut->query('per_page'), 5);
        $this->assertEquals($sut->query('page_number'), 10);        
    }

    public function testShouldThrowValidationExceptionOnInvalidPerPage() {
        $sut = new PageableRequest(['per_page' => 'ERROR' ]);

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->assertFalse($validator->passes());

        $this->assertEquals($validator->errors()->first('per_page'), 'The per page field must be an integer.');
    }

    public function testShouldThrowValidationExceptionOnInvalidPageNumber() {
        $sut = new PageableRequest(['page_number' => 'ERROR' ]);

        $validator = Validator::make($sut->input(), $sut->rules());
        $this->assertFalse($validator->passes());

        $this->assertEquals($validator->errors()->first('page_number'), 'The page number field must be an integer.');
    }
}
