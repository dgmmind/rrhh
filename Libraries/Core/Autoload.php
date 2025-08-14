<?php
// Registra un autoloader para incluir automáticamente los archivos de clase
spl_autoload_register(/**
 * Función autoload para archivos de clase.
 *
 * Esta función intenta cargar automáticamente el archivo de clase
 * cuando de instancia una clase. Construye la ruta del archivo
 * en función de un directorio base predefinido y el nombre de la clase.
 *
 * @param string $class El nombre de la clase a cargar.
 * @throws Exception Si no se puede encontrar el archivo de la clase.
 */
    function (string $class) {
        // Define el directorio base para los archivos de clase
        $baseDir = 'Libraries' . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR;
        // Construye la ruta completa del archivo
        $filePath = $baseDir . $class . '.php';

        // Verifica si el archivo existe
        if (file_exists($filePath)) {
            require_once $filePath; // Incluye el archivo de clase
        } else {
            // Opcionalmente, registra el error antes de lanzar una excepción
            error_log("Archivo de clase no encontrado: $filePath");
            throw new Exception("Archivo de clase no encontrado: $filePath"); // Lanza una excepción si el archivo no se encuentra
        }
    });