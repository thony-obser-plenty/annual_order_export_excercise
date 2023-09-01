<?php namespace App\Queue;

class Queue implements QueueInterface
{
    private array $queue = [];

    public function add($name, $item): void
    {
        $this->queue[$name] = $item;
    }

    public function getQueue(): array
    {
        return $this->queue;
    }

    public function sort(): void
    {
        ksort($this->queue);
    }
}