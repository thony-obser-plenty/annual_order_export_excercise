<?php namespace App\Queue;

class Enqueuer implements EnqueuerInterface
{
    public static function enqueue($queueCollection, $orders): QueueCollection
    {
        foreach ($orders as $order) {
            $timestamp = strtotime($order->getDate());
            $month = strtolower(date('F', $timestamp));
            $queueCollection->getQueue($month)->add($timestamp, $order);
        }

        return $queueCollection;
    }
}
