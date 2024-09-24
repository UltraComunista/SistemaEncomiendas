<?php
// api/index.php

// Incluir configuración global
require_once '../config/config.php';

// Incluir rutas de la API
require_once 'routes/routes.php';

// Configurar encabezado de respuesta para JSON
header('Content-Type: application/json');
// Ruta para manejar el callback
$app->post('/callback', function () {
    CallbackController::handleCallback();
});

// Procesar la solicitud
$router = new ApiRouter();
$router->handle($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
