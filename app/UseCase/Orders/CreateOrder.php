<?php
namespace UseCase\Orders;

use UseCase\Menus\MenuRepositoryInterface;

class CreateOrder
{
    public function __construct(
        private MenuRepositoryInterface $menuRepo,
        private OrderRepositoryInterface $orderRepo
    ) {}

    public function execute(string $shippingAddress, string $deliveryDate, array $quantities): bool
    {
        $menus = $this->menuRepo->findAll();

        $lines      = [];
        $totalPrice = 0.0;

        foreach ($menus as $menu) {
            $qty = (int) ($quantities[$menu->id] ?? 0);
            if ($qty <= 0) continue;

            $unitPrice  = (float) $menu->totalPrice;
            $linePrice  = $unitPrice * $qty;

            $lines[] = [
                'menuId'       => $menu->id,
                'menuNom'      => $menu->name,
                'quantite'     => $qty,
                'prixUnitaire' => $unitPrice,
                'prixLigne'    => $linePrice,
            ];
            $totalPrice += $linePrice;
        }

        if (empty($lines)) return false;

        return $this->orderRepo->create(
            1,
            date('Y-m-d\TH:i:s'),
            $shippingAddress,
            $deliveryDate,
            $lines,
            $totalPrice
        );
    }
}