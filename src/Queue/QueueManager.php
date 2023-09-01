<?php namespace App\Queue;

class QueueManager implements QueueManagerInterface
{
    private QueueCollectionInterface $queueCollection;

    public function setupQueues(): void
    {
        $months = [
            'january', 'february', 'march', 'april', 'may', 'june',
            'july', 'august', 'september', 'october', 'november', 'december'
        ];

        $queueCollection = new QueueCollection();

        foreach ($months as $month) {
            $queueCollection->addQueue($month, new Queue());
        }

        $this->queueCollection = $queueCollection;
    }

    public function getQueueCollection(): QueueCollectionInterface
    {
        return $this->queueCollection;
    }
}