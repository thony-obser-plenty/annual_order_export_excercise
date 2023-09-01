<?php

namespace App\Queue;

interface QueueCollectionInterface
{
    public function addQueue(string $name, Queue $queue): void;

    public function getQueue(string $name): ?Queue;

    public function getQueues(): array;
}