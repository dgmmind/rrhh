<?php
class Users extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
        getPermissions(MD_ROLES);
    }

    /**
     * @throws Exception
     */
    public function users(): void
    {
        $data["pageName"]     = "users";
        $data["pageTitle"]     = "Usuarios";
        $users = $this->model->getUsers();
        //debug($_SESSION['permissions']);
        //debug($_SESSION['permissionsModule']);
        $this->views->getViews($this, 'users', $data,$users);
    }

    /**
     * @throws Exception
     */
    public function new(): void{
        $data["pageName"]     = "newUser";
        $this->views->getViews($this, 'new', $data);

    }
    public function setNewUser(): void{
        $user     = "newUser";
        $users = $this->model->setNewUser($user);

    }
}