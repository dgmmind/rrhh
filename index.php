<?php
session_start(); // Inicia la sesión
//session_destroy();
// Carga configuraciones y helpers
require_once 'Settings/Settings.php';
require_once 'Helpers/Helpers.php';
// Genera un token CSRF si no existe
$_SESSION['X-CSRF-TOKEN'] ??= generateCsrfToken(32, 'X-CSRF_', true);
// Obtiene y limpia la ruta
$route = filter_input(INPUT_GET, 'route', FILTER_SANITIZE_STRING) ?? 'home/home';
// Procesa la URI
$requestUri = rtrim(implode('/', array_slice(explode('/', trim($_SERVER['REQUEST_URI'], '/')), 1)), '/');
// Verifica si está en la raíz ("/") y la ruta por defecto es 'home/home'
if (!empty($requestUri)) {
    // Limpia la ruta de caracteres no permitidos y redirige si es necesario
    if (preg_match('/[^a-zA-Z0-9\/]/', $route) || str_ends_with($route, '/')) {
        $cleanRoute = rtrim(preg_replace('/[^a-zA-Z0-9\/]/', '', $route), '/');
        header("Location: /insider/$cleanRoute");
        exit;
    }
    // Redirige si la URI no coincide con la ruta
    if ($requestUri !== rtrim($route, '/')) {
        header("Location: /insider/$route");
        exit;
    }
}
// Procesa el controlador, método y parámetros
$routeParts = explode('/', $route);
$controller = ucfirst(strtolower($routeParts[0]));
$method = $routeParts[1] ?? $controller;
$parameter = array_slice($routeParts, 2);
// Carga el autoloader y dependencias
require_once 'Libraries/Core/Autoload.php';
require_once 'Libraries/Core/Load.php';