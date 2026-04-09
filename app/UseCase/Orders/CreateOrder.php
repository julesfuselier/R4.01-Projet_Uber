<?php

namespace UseCase\Orders;

use Domain\Order;
use Domain\OrderLine;

/**
 * Cas d'usage : crée et persiste une nouvelle commande.
 */
class CreateOrder
{
    public function __construct(
        private OrderRepositoryInterface $orderRepo
    ) {}

    /**
     * @return bool False si la requête ne contient aucune ligne.
     */
    public function execute(CreateOrderRequest $request): bool
    {
        if (empty($request->lines)) {
            return false;
        }

        $order                  = new Order();
        $order->subscriberId    = 1;
        $order->orderDate       = date('Y-m-d\TH:i:s');
        $order->shippingAddress = $request->shippingAddress;
        $order->deliveryDate    = $request->deliveryDate;

        foreach ($request->lines as $lineData) {
            $order->addLine(new OrderLine(
                $lineData->menuId,
                $lineData->menuName,
                $lineData->unitPrice,
                $lineData->quantity
            ));
        }

        $order->totalPrice = $order->computeTotal();

        return $this->orderRepo->save($order);
    }
}