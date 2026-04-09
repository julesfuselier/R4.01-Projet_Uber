<?php

namespace UseCase\Menus;

/**
 * DTO portant les données nécessaires à la création d'un menu.
 */
class CreateMenuRequest
{
    /**
     * @param string   $name      Nom du menu.
     * @param int      $creatorId Identifiant de l'utilisateur créateur.
     * @param int[]    $dishIds   Identifiants des plats à associer.
     */
    public function __construct(
        public readonly string $name,
        public readonly int    $creatorId,
        public readonly array  $dishIds
    ) {}
}