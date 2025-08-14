<?php
/**
 * Class Controllers
 *
 * Esta clase sirve como controlador base en el framework MVC.
 * Se encarga de cargar el modelo correspondiente y manejar la
 * interacción entre el modelo y las vistas.
 */
class Controllers
{
    /**
     * @var mixed
     *
     * Almacena la instancia del modelo que se está utilizando.
     */
    protected mixed $model;

    /**
     * @var Views
     *
     * Instancia de la clase Views que se utiliza para renderizar
     * las vistas correspondientes a las acciones del controlador.
     */
    protected Views $views;

    /**
     * Controllers constructor.
     *
     * Inicializa una nueva instancia de la clase Controllers.
     */
    public function __construct()
    {
        $this->views = new Views();
        $this->loadModel();
    }

    /**
     * Carga el modelo correspondiente a este controlador.
     *
     * El nombre del modelo se deriva del nombre de la clase del controlador
     * añadiendo 'Model' al final.
     *
     * @return void
     */
    public function loadModel(): void
    {
        $model = get_class($this) . 'Model';
        $routeClass = 'Models/' . $model . ".php";

        if (file_exists($routeClass)) {
            require_once $routeClass;
            $this->model = new $model();
        }
    }
}