<?php
/**
 *
 */
class HelpersModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function verifyId(string $table, string $column, int $id): array
    {
        $query = "SELECT COUNT(*) as total FROM {$table} WHERE {$column} = ?";
        return $this->find($query, [$id]);
    }
}
