<?php

namespace UseCase\Menus;

/**
 * DTO portant les données nécessaires à la mise à jour d'un menu.
 */
class UpdateMenuRequest
{
    /**
     * @param int    $id      Identifiant du menu à modifier.
     * @param string $name    Nouveau nom du menu.
     * @param int[]  $dishIds Nouveaux identifiants de plats à associer.
     */
    public function __construct(
        public readonly int    $id,
        public readonly string $name,
        public readonly array  $dishIds = []
    ) {}
}