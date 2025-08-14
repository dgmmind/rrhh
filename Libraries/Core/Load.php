<?php
// Variables globales que almacenan el controlador, el método y los parámetros.
global $controller, $method, $parameter;
/**
 * Carga un controlador y llama al método especificado con los parámetros proporcionados.
 *
 * Este función busca el archivo del controlador en la carpeta 'Controllers',
 * verifica si existe la clase del controlador y si el método solicitado
 * pertenece a esa clase. Además, se asegura de que el número de parámetros
 * proporcionados sea correcto antes de invocar el método.
 *
 * @param string $controller Nombre del controlador a cargar.
 * @param string $method Nombre del método que se desea ejecutar en el controlador.
 * @param mixed|null $parameter Parámetro opcional que se pasará al método.
 * @return void
 * @throws ReflectionException
 */
function loadController(string $controller, string $method, mixed $parameter = null): void
{
    // Define la ruta del archivo del controlador
    $controllerFile = 'Controllers/' . ucfirst(strtolower($controller)) . '.php';

    // Verifica si el archivo del controlador existe
    if (!file_exists($controllerFile)) {
        handleError(); // Maneja el error si el archivo no se encuentra
        return;
    }
    require_once $controllerFile; // Incluye el archivo del controlador
    // Verifica si la clase del controlador existe
    if (!class_exists($controller)) {
        handleError(); // Maneja el error si la clase no se encuentra
        return;
    }
    // Crea una instancia del controlador
    $controllerInstance = new $controller();
    // Verifica si el método existe en la instancia del controlador
    if (!method_exists($controllerInstance, $method)) {
        handleError(); // Maneja el error si el método no se encuentra
        return;
    }
    // Obtener el número de parámetros requeridos y totales del método
    $reflection = new ReflectionMethod($controllerInstance, $method);
    $numRequiredParams = $reflection->getNumberOfRequiredParameters();
    $numTotalParams = $reflection->getNumberOfParameters();
    // Preparar los argumentos para la llamada al método
    $args = is_null($parameter) ? [] : (is_array($parameter) ? $parameter : [$parameter]);
    $numArgs = count($args);
    // Verifica si el número de argumentos es válido
    if ($numArgs < $numRequiredParams || $numArgs > $numTotalParams) {
        handleError(); // Maneja el error si los argumentos no son válidos
        return;
    }
    // Llama al método con los parámetros proporcionados
    $reflection->invokeArgs($controllerInstance, $args);
}
// Carga el controlador especificado
try {
    loadController($controller, $method, $parameter);
} catch (ReflectionException $e) {
    echo $e->getMessage();
}