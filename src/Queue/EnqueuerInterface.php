<?php

namespace App\Queue;

interface EnqueuerInterface
{
    public static function enqueue(QueueCollectionInterface $queueCollection, array $orders): QueueCollectionInterface;
}