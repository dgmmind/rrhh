<?php
class Dashboard extends Controllers
{
    protected Views $views;
    public function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['userId']) || !isset($_SESSION['login'])) {

            header('Location:'.router().'auth/login');
            exit();
        }
        getPermissions(MD_DASHBOARD);

    }
    /**
     * @throws Exception
     */
    public function dashboard(): void
    {
        $data["pageName"]     = "dashboard";

   //debug($_SESSION['permissionsModule']);

    //debug($_SESSION['permissions']);
    //echo $_SESSION['userId'];
        //echo $_SESSION['login'];
        $this->views->getViews($this, 'dashboard', $data);
    }
}