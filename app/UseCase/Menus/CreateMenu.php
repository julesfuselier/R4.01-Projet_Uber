<?php
namespace UseCase\Menus;

class CreateMenu
{
    public function execute($nomMenu, $createurNom, $platsIds) {
        $jsonPlats = file_get_contents('http://localhost:3003/plats');
        $tousLesPlats = json_decode($jsonPlats, true);

        $platsPourLeMenu = [];
        $prixTotal = 0;

        if ($tousLesPlats && is_array($platsIds)) {
            foreach($tousLesPlats as $plat) {
                if (in_array($plat['id'], $platsIds)) {
                    $platsPourLeMenu[] = [
                        "id" => (int) $plat['id'],
                        "nom" => $plat['nom'],
                        "prix" => (float) $plat['prix']
                    ];
                    $prixTotal += (float) $plat['prix'];
                }
            }
        }

        $data = [
            "nom" => $nomMenu,
            "createurNom" => $createurNom,
            "dateCreation" => date("Y-m-d"),
            "dateMiseAJour" => date("Y-m-d"),
            "plats" => $platsPourLeMenu,
            "prixTotal" => $prixTotal
        ];
        $payload = json_encode($data);

        $ch = curl_init('http://localhost:3004/menus');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload)
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}