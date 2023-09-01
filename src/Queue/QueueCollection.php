<?php namespace App\Queue;

class QueueCollection implements QueueCollectionInterface
{
    private array $queues = [];

    public function addQueue(string $name, Queue $queue): void
    {
        $this->queues[$name] = $queue;
    }

    public function getQueue(string $name): ?Queue
    {
        return $this->queues[$name] ?? null;
    }

    public function getQueues(): array
    {
        return $this->queues;
    }
}