<?php
class Mysql extends Connection
{
    private ?PDO $connection;
    public function __construct()
    {
        parent::__construct();
        $this->connection = self::getInstance();
    }
    /**
     * Inserta datos en la base de datos.
     *
     * @param string $query Consulta SQL para la inserción
     * @param array $arrayValues Valores a insertar
     * @return int ID del último registro insertado
     * @throws Exception
     */
    public function save(string $query, array $arrayValues): int
    {
        //$this->beginTransaction();
        try {
            $insert = $this->prepareAndExecute($query, $arrayValues);
            //$this->commitTransaction();
            return $insert ? (int) $this->connection->lastInsertId() : 0;
        } catch (Exception $e) {
            //$this->rollbackTransaction();
            throw new Exception("Error al insertar datos: " . $e->getMessage());
        }
    }
    /**
     * Encuentra un registro en la base de datos.
     *
     * @param string $query Consulta SQL para encontrar el registro
     * @param array $params Parámetros para la consulta
     * @return array|null Registro encontrado
     * @throws Exception
     */
    public function find(string $query, array $params = []): ?array
    {
        return $this->executeQuery($query, $params, false);
    }
    /**
     * Encuentra todos los registros en la base de datos.
     *
     * @param string $query Consulta SQL para encontrar registros
     * @param array $params Parámetros para la consulta
     * @return array Registros encontrados
     * @throws Exception
     */
    public function findAll(string $query, array $params = []): array
    {
        return $this->executeQuery($query, $params, true);
    }
    /**
     * Actualiza un registro en la base de datos.
     *
     * @param string $query Consulta SQL para la actualización
     * @param array $arrayValues Valores a actualizar
     * @return bool Verdadero en caso de éxito, falso en caso de fallo
     * @throws Exception
     */
    public function updateRecord(string $query, array $arrayValues): bool
    {
        $this->beginTransaction();
        try {
            $result = $this->prepareAndExecute($query, $arrayValues);
            $this->commitTransaction();
            return $result !== false;
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw new Exception("Error al actualizar datos: " . $e->getMessage());
        }
    }
    /**
     * Elimina un registro de la base de datos.
     *
     * @param string $query Consulta SQL para la eliminación
     * @param array $params Parámetros para la consulta
     * @return bool Verdadero en caso de éxito, falso en caso de fallo
     * @throws Exception
     */
    public function deleteRecord(string $query, array $params = []): bool
    {
        $this->beginTransaction();
        try {
            $result = $this->prepareAndExecute($query, $params);
            $this->commitTransaction();
            return $result !== false;
        } catch (Exception $e) {
            $this->rollbackTransaction();
            throw new Exception("Error al eliminar datos: " . $e->getMessage());
        }
    }
    /**
     * Prepara y ejecuta una declaración SQL.
     *
     * @param string $query Consulta SQL
     * @param array $params Parámetros para la consulta
     * @return PDOStatement|null
     * @throws Exception
     */
    private function prepareAndExecute(string $query, array $params = []): ?PDOStatement
    {
        try {
            $stmt = $this->connection->prepare($query);
            $expectedParams = substr_count($query, '?');
            if (count($params) !== $expectedParams) {
                throw new Exception("El número de parámetros no coincide con los marcadores de posición en la consulta.");
            }
            $stmt->execute($params); // Ejecuta la consulta con los parámetros
            return $stmt; // Retorna el objeto PDOStatement
        } catch (Exception $e) {
            // Maneja la excepción de número incorrecto de parámetros
            error_log($e->getMessage());
            throw $e; // Lanza la excepción para que pueda ser manejada en updateRecord
        }
    }
    /**
     * Ejecuta una consulta y obtiene los resultados.
     *
     * @param string $query Consulta SQL
     * @param array $params Parámetros para la consulta
     * @param bool $fetchAll Si se deben obtener todos los registros o solo uno
     * @return array|null
     * @throws Exception
     */
    private function executeQuery(string $query, array $params, bool $fetchAll): ?array
    {
        $result = $this->prepareAndExecute($query, $params);
        if ($result === null) {
            return null;
        }

        // Retorna los resultados según el parámetro $fetchAll
        return $fetchAll ? $result->fetchAll(PDO::FETCH_ASSOC) : ($result->fetch(PDO::FETCH_ASSOC) ?: []);
    }
    protected function inTransaction(): bool
    {
        return $this->connection->inTransaction();
    }
    protected function beginTransaction(): void
    {
        if (!$this->inTransaction()) {
            $this->connection->beginTransaction();
        }
    }
    protected function commitTransaction(): void
    {
        if ($this->inTransaction()) {
            $this->connection->commit();
        }
    }
    protected function rollbackTransaction(): void
    {
        if ($this->inTransaction()) {
            $this->connection->rollBack();
        }
    }
    /**
     * Sanitiza los datos de entrada.
     *
     * @param array $data Datos de entrada
     * @return array Datos sanitizados
     */
    public function sanitizeInput(array $data): array
    {
        foreach ($data as $key => $value) {
            $data[$key] = htmlspecialchars(strip_tags($value));
        }
        return $data;
    }
}