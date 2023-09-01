<?php namespace App\OrderExport;

class OrderExport implements OrderExportInterface
{
    private OrderPreProcessorInterface $orderPreProcessor;
    private OrderExporterInterface $orderExporter;

    public function __construct(OrderPreProcessorInterface $orderPreProcessor, OrderExporterInterface $orderExporter)
    {
        $this->orderPreProcessor = $orderPreProcessor;
        $this->orderExporter = $orderExporter;
    }

    public function exportOrders(): bool
    {
        $orders = $this->orderPreProcessor->prepareOrders();
        return $this->orderExporter->exportOrders($orders);
    }
}