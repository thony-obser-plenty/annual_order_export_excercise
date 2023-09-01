<?php

namespace App\Command;

use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\OrderItems;
use App\Mapper\OrderDataMapperInterface;

class OrderDataMapper implements OrderDataMapperInterface
{
    public static function map($order): Order
    {
        $orderEntity = new Order();

        $orderEntity->setId($order['Id']);
        $orderEntity->setDate($order['Date']);
        $orderEntity->setStatusId($order['StatusId']);
        $orderEntity->setAddress($order['Address']);

        $orderItemsEntity = new OrderItems();
        foreach ($order['OrderItems'] as $orderItem) {
            $orderItemEntity = new OrderItem();
            $orderItemEntity->setId($orderItem['ID']);
            $orderItemEntity->setCreatedAt($orderItem['CreatedAt']);
            $orderItemEntity->setUpdatedAt($orderItem['UpdatedAt']);
            $orderItemEntity->setDeletedAt($orderItem['DeletedAt']);
            $orderItemEntity->setProductName($orderItem['ProductName']);
            $orderItemEntity->setOrderId($orderItem['OrderId']);

            $orderItemsEntity->addOrderItem($orderItemEntity);
        }
        $orderEntity->setOrderItems($orderItemsEntity);

        return $orderEntity;
    }
}