<?php
namespace Infrastructure;

use Config\ApiConfig;
use Domain\Menu;
use UseCase\Menus\MenuRepositoryInterface;

class HttpMenuRepository implements MenuRepositoryInterface
{
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
                $menu->createdBy  = $item['createurNom'];
                $menu->totalPrice = $item['prixTotal'];
                $menus[] = $menu;
            }
        }
        return $menus;
    }

    public function create(string $name, string $createdBy, array $dishes, float $totalPrice): bool
    {
        // Mapping Domain → format attendu par l'API Menus (champs français)
        $plats = array_map(fn($d) => [
            'id'  => (int)   $d->id,
            'nom' => $d->name,
            'prix' => (float) $d->price,
        ], $dishes);

        $payload = json_encode([
            'nom'           => $name,
            'createurNom'   => $createdBy,
            'dateCreation'  => date('Y-m-d'),
            'dateMiseAJour' => date('Y-m-d'),
            'plats'         => $plats,
            'prixTotal'     => $totalPrice,
        ]);

        $ch = curl_init(ApiConfig::MENUS_API_BASE . '/menus');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }
}