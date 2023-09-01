<?php namespace App\Entity;

class Order
{
    private ?int $id = null;
    private ?string $date = null;
    private ?int $statusId = null;
    private ?string $address = null;
    private ?OrderItems $orderItems = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(?string $date): void
    {
        $this->date = $date;
    }

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }

    public function setStatusId(?int $statusId): void
    {
        $this->statusId = $statusId;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }

    public function getOrderItems(): ?OrderItems
    {
        return $this->orderItems;
    }

    public function setOrderItems(?OrderItems $orderItems): void
    {
        $this->orderItems = $orderItems;
    }
}