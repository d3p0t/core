<?php

namespace D3p0t\Core\Requests;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;

abstract class ModelRequest extends FormRequest {
    
    abstract public function toModel(): Model;

}
