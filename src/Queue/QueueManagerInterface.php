<?php

namespace App\Queue;

interface QueueManagerInterface
{
    public function setupQueues(): void;

    public function getQueueCollection(): QueueCollectionInterface;
}