<?php

namespace Infrastructure;

use Config\ApiConfig;
use Domain\Menu;
use UseCase\Menus\MenuRepositoryInterface;

/**
 * Implémentation HTTP du repository des menus (Java Menu Service).
 */
class HttpMenuRepository implements MenuRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function findAll(): array
    {
        $json = file_get_contents(ApiConfig::MENUS_API_BASE . '/menus');
        $data = json_decode($json, true);

        $menus = [];
        if ($data) {
            foreach ($data as $item) {
                $menu = new Menu();
                $menu->id         = $item['id'];
                $menu->name       = $item['nom'];
                $menu->creatorId  = $item['createurId'];
                $menu->createdBy  = $item['createurNom'];
                $menu->totalPrice = $item['prixTotal'];
                $menus[] = $menu;
            }
        }
        return $menus;
    }

    /** {@inheritDoc} */
    public function create(\Domain\Menu $menu): int
    {
        $payload = json_encode(['name' => $menu->name, 'creatorId' => $menu->creatorId]);

        $ch = curl_init(ApiConfig::MENUS_API_BASE . '/menus');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        if ($result === false) return 0;
        $data = json_decode($result, true);
        return $data['id'] ?? 0;
    }

    /** {@inheritDoc} */
    public function addDish(int $menuId, int $dishId): bool
    {
        $ch = curl_init(ApiConfig::MENUS_API_BASE . '/menus/' . $menuId . '/plats/' . $dishId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        $result = curl_exec($ch);
        curl_close($ch);
        return $result !== false;
    }

    /** {@inheritDoc} */
    public function update(\Domain\Menu $menu): bool
    {
        $payload = json_encode(['name' => $menu->name]);

        $ch = curl_init(ApiConfig::MENUS_API_BASE . '/menus/' . $menu->id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }

    /** {@inheritDoc} */
    public function delete(int $id): bool
    {
        $ch = curl_init(ApiConfig::MENUS_API_BASE . '/menus/' . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }
}