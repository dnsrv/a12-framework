<?php

namespace A12\Modules\Container;

use A12\Interfaces\Exceptions\ModuleExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ServiceNotFoundException
    extends \InvalidArgumentException
    implements NotFoundExceptionInterface, ModuleExceptionInterface
{

}
