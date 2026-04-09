<?php

namespace Config;

/**
 * Centralise les URL de base des APIs externes consommées par le frontend.
 */
class ApiConfig
{
    const JAVA_API_BASE    = 'http://localhost:8080/uber/api';
    const DISHES_API_BASE  = 'http://localhost:8080/uber/api/dishes';
    const MENUS_API_BASE   = 'http://localhost:8080/menu/api';
    const ORDERS_API_BASE  = 'http://localhost:3005';
}