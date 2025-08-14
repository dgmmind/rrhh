<?php
/**
 *
 */
class RolesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function getRoles(): ?array
    {
        $query   = "SELECT * FROM roles WHERE roleStatus != 0";
        return $this->findAll($query);
    }
    public function setNewUser(string $user): ?array{
        return array("id" => $user, "name" => $user);
    }
}