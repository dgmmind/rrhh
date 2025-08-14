<?php
class Views
{
    private const VIEWS_PATH = 'Views/';

    /**
     * Renderiza la vista especificada para el controlador dado.
     *
     * @param object $controller El objeto del controlador
     * @param string $view El nombre de la vista a renderizar
     * @param array $data Datos opcionales para pasar a la vista
     * @throws Exception Si la vista no se encuentra.
     */
    public function getViews(object $controller, string $view, array $data = [], array $data1 = [], array $data2 = [], array $data3 = []): void
    {
        $controllerName = (new \ReflectionClass($controller))->getShortName();
        $viewPath = self::VIEWS_PATH . ($controllerName === 'Home' ? '' : $controllerName . '/') . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new Exception("La vista $viewPath no fue encontrada.");
        }

        require_once $viewPath;
    }
}