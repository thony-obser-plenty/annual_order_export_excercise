<?php namespace App\Providers;

interface OrderDataProviderInterface
{
    public function fetchOrders($page): array;

    public function fetchPageCount(): int;
}