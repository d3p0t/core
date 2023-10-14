<?php

namespace D3p0t\Core\Test\Unit\Exceptions;

use D3p0t\Core\Exceptions\ModelValidationException;
use D3p0t\Core\Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Illuminate\Validation\ValidationException;
use Mockery\MockInterface;

class ModelValidationExceptionTest extends TestCase {

    public function testShouldMapModelValidationException() {
        $validator = $this->mock(LengthAwarePaginator::class, function(MockInterface $interface) {
            $errors = new MessageBag(['TEST ERROR']);

            $interface->shouldReceive('errors') 
                ->andReturn($errors);
        });

        $cause = new ValidationException($validator);
        $model = new Class extends Model { };

        $sut = new ModelValidationException($cause, $model);

        $this->assertEquals($sut->getMessage(), 'TEST ERROR');
        $this->assertEquals($sut->cause(), $cause);
        $this->assertEquals($sut->model(), $model);
    }

    public function testShouldRender() {
        $validator = $this->mock(LengthAwarePaginator::class, function(MockInterface $interface) {
            $errors = new MessageBag(['TEST ERROR']);

            $interface->shouldReceive('errors') 
                ->andReturn($errors);
        });

        $cause = new ValidationException($validator);
        $model = new Class extends Model { };

        $sut = new ModelValidationException($cause, $model);

        $this->assertEquals($sut->render(null)->content(), 'TEST ERROR');
        $this->assertEquals($sut->render(null)->status(), 500);
    }
}
