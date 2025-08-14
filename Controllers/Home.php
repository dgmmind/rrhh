<?php
class Home extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function home(): void
    {
        $data["PAGE_NAME"]     = "home";


        $this->views->getViews($this, 'home', $data);
    }
}