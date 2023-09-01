<?php

namespace App\OrderExport;

use App\Queue\QueueCollection;

interface OrderPreProcessorInterface
{
    public function prepareOrders(): QueueCollection;

    public function mapOrders($orders): array;
}