<?php namespace App\OrderExport;

class OrderExporter implements OrderExporterInterface
{
    public function exportOrders($queueCollection): bool
    {
        foreach ($queueCollection->getQueues() as $name => $queue) {
            $queue->sort();

            $filePath = __DIR__ . '/../../var/export/';
            $file = fopen("$filePath$name.csv", "w");

            if ($file === false) {
                throw new \Exception('Error opening file');
            }

            $header = ['Id', 'Date', 'StatusId', 'Address', 'OrderItems'];
            $bytesWritten = fputcsv($file, $header);

            if ($bytesWritten === false) {
                throw new \Exception('Error writing header');
            }

            foreach ($queue->getQueue() as $order) {
                $orderItems = [];
                foreach ($order->getOrderItems()->getOrderItems() as $orderItem) {
                    $orderItems[] = $orderItem->getId();
                    $orderItems[] = $orderItem->getCreatedAt();
                    $orderItems[] = $orderItem->getUpdatedAt();
                    $orderItems[] = $orderItem->getDeletedAt();
                    $orderItems[] = $orderItem->getProductName();
                    $orderItems[] = $orderItem->getOrderId();
                }

                $row = [
                    $order->getId(),
                    $order->getDate(),
                    $order->getStatusId(),
                    $order->getAddress(),
                    implode(':', $orderItems)
                ];

                $bytesWritten = fputcsv($file, $row);

                if ($bytesWritten === false) {
                    throw new \Exception('Error writing row');
                }
            }

            fclose($file);
        }

        return true;
    }
}