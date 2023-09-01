<?php

namespace App\Mapper;

use App\Entity\Order;

interface OrderDataMapperInterface
{
    public static function map(array $order): Order;
}