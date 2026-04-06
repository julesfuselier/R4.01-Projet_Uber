<?php
namespace Domain;

class Order
{
    public $id;
    public $subscriberId;
    public $orderDate;
    public $shippingAddress;
    public $deliveryDate;
    public $lines = [];
    public $totalPrice;
}