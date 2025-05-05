<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class ExistUserException extends HttpException
{
    public function __construct($message)
    {
        parent::__construct(400, $message);
    }
}
