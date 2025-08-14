<?php
/**
 * Class Connection
 *
 * Esta clase establece y gestiona la conexión a la base de datos utilizando PDO.
 * Implementa el patrón de diseño Singleton para asegurar que solo haya una
 * conexión activa a la base de datos en toda la aplicación.
 */
class Connection
{
    /**
     * @var PDO|null
     *
     * Almacena la instancia de conexión PDO.
     * Se inicializa como null hasta que se establece una conexión.
     */
    private static ?PDO $connect = null;

    /**
     * Connection constructor.
     *
     * Este constructor verifica si la conexión a la base de datos ya
     * está establecida. Si no es así, llama al método para establecerla.
     *
     * @throws Exception Si la conexión a la base de datos falla.
     */
    public function __construct()
    {
        // Si la conexión ya está establecida, no hace falta volver a conectarse
        if (self::$connect === null) {
            $this->connectDB();
        }
    }

    /**
     * Establishes a database connection.
     *
     * Este método establece una nueva conexión a la base de datos utilizando
     * PDO. Configura el modo de error para lanzar excepciones en caso de errores.
     *
     * @throws Exception Si hay un problema al conectar a la base de datos.
     */
    private function connectDB(): void
    {
        $connectionString = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

        try {
            self::$connect = new PDO($connectionString, DB_USER, DB_PASSWORD);
            self::$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "New connection established"; // Útil para depuración
        } catch (PDOException $e) {
            self::$connect = null;
            // En producción, es mejor registrar el error en lugar de mostrarlo
            error_log("Database connection error: " . $e->getMessage());
            throw new Exception("Database connection failed.");
        }
    }

    /**
     * Gets the instance of the PDO connection.
     *
     * Este método devuelve la instancia de conexión PDO. Si no existe
     * una conexión activa, se crea una nueva.
     *
     * @throws Exception Si hay un problema al conectar a la base de datos.
     * @return PDO|null La instancia de conexión PDO o null si falla la conexión.
     */
    public static function getInstance(): ?PDO
    {
        // Si no existe una conexión, crearla
        if (self::$connect === null) {
            (new self())->connectDB();
        }
        return self::$connect;
    }
}