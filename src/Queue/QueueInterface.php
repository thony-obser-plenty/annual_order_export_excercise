<?php

namespace App\Queue;

interface QueueInterface
{
    public function add($name, $item): void;

    public function getQueue(): array;
}