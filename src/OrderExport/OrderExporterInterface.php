<?php

namespace App\OrderExport;

interface OrderExporterInterface
{
    public function exportOrders($queueCollection);
}