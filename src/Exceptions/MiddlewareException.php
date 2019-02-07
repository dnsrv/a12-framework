<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 2:36
 */

namespace A12\Exceptions;


use A12\Interfaces\Exceptions\MiddlewareExceptionInterface;
use Throwable;

class MiddlewareException extends BasicException implements MiddlewareExceptionInterface
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct("Middleware: " . $message, $code, $previous);
    }
}