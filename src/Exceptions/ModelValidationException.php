<?php

namespace D3p0t\Core\Exceptions;

use Exception;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class ModelValidationException extends Exception
{

    private ValidationException $cause;
    private Model $model;

    public function __construct(ValidationException $cause, Model $model)
    {
        parent::__construct($cause->message);

        $this->cause = $cause;
        $this->model = $model;
    }

    public function model(): Model {
        return $this->model;
    }

    public function cause(): ValidationException {
        return $this->cause;
    }

    public function render(?Request $request = null): Response
    {
        return response(
            $this->message,
            500
        );
    }
}

