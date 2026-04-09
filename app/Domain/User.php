<?php

namespace Domain;

/**
 * Entité représentant un utilisateur de la plateforme.
 */
class User
{
    /** @var int */
    public $id;

    /** @var string */
    public $firstName;

    /** @var string */
    public $lastName;

    /** @var string */
    public $email;

    /** @var string Rôle parmi : ADMIN, RESTAURANT_OWNER, CUSTOMER */
    public $role;
}