<?php

namespace App\OrderExport;

interface OrderExportInterface
{
    public function exportOrders(): bool;
}