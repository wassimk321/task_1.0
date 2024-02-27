<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 *
 */
abstract class AbstractException extends Exception
{
    use ApiResponser;

    public function render()
    {
        throw new HttpResponseException(
            $this->exceptionErrorResponse($this->message())
        );
    }

    abstract public function message();
}
