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

    public function create(\Domain\Menu $menu): bool
    {
        $payload = $this->buildPayload($menu);

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

    public function update(\Domain\Menu $menu): bool
    {
        $payload = $this->buildPayload($menu);

        $ch = curl_init(ApiConfig::MENUS_API_BASE . '/menus/' . $menu->id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload),
        ]);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result !== false;
    }

    private function buildPayload(\Domain\Menu $menu): string
    {
        $plats = array_map(fn($d) => [
            'id'   => (int)   $d->id,
            'nom'  => $d->name,
            'prix' => (float) $d->price,
        ], $menu->dishes);

        return json_encode([
            'nom'           => $menu->name,
            'createurNom'   => $menu->createdBy,
            'dateCreation'  => date('Y-m-d'),
            'dateMiseAJour' => date('Y-m-d'),
            'plats'         => $plats,
            'prixTotal'     => $menu->totalPrice,
        ]);
    }

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