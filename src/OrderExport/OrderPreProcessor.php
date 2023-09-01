<?php

namespace App\OrderExport;

use App\Command\OrderDataMapper;
use App\Providers\AuthenticationTokenProviderInterface;
use App\Providers\OrderDataProviderInterface;
use App\Queue\Enqueuer;
use App\Queue\QueueCollection;
use App\Queue\QueueManagerInterface;

class OrderPreProcessor implements OrderPreProcessorInterface
{
    private AuthenticationTokenProviderInterface $authenticationTokenProvider;
    private OrderDataProviderInterface $orderDataProvider;
    private QueueManagerInterface $queueManager;

    public function __construct(AuthenticationTokenProviderInterface $authenticationTokenProvider, OrderDataProviderInterface $orderDataProvider, QueueManagerInterface $queueManager)
    {
        $this->authenticationTokenProvider = $authenticationTokenProvider;
        $this->orderDataProvider = $orderDataProvider;
        $this->queueManager = $queueManager;
    }

    public function prepareOrders(): QueueCollection
    {
        $this->queueManager->setupQueues();
        $queueCollection = $this->queueManager->getQueueCollection();

        $authenticationToken = $this->authenticationTokenProvider->fetchAuthenticationToken();
        $this->orderDataProvider->setupHttpClient($authenticationToken);

        $pageCount = $this->orderDataProvider->fetchPageCount();
        for ($page = 1; $page <= $pageCount; $page++) {
            $orders = $this->orderDataProvider->fetchOrders($page);
            $orderEntities = $this->mapOrders($orders);
            $queueCollection = Enqueuer::enqueue($queueCollection, $orderEntities);
        }

        return $queueCollection;
    }

    public function mapOrders($orders): array
    {
        $orderEntities = [];

        foreach ($orders as $order) {
            $orderEntities[] = OrderDataMapper::map($order);
        }

        return $orderEntities;
    }
}