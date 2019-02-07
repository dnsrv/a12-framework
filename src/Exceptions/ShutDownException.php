<?php
/**
 * Created by PhpStorm.
 * User: d3n
 * Date: 06.12.18
 * Time: 2:05
 */

namespace A12\Exceptions;


use A12\Interfaces\Exceptions\ShutDownExceptionInterface;
use Throwable;

class ShutDownException extends BasicException implements ShutDownExceptionInterface
{
    public function __construct(string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message . " ...Stopping", $code, $previous);
    }
}