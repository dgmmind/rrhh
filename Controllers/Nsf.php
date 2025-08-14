<?php
class Nsf extends Controllers
{
    protected Views $views;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @throws Exception
     */
    public function nsf(): void
    {
        $data["pageName"]     = "nsf";


        $this->views->getViews($this, 'nsf', $data);
    }
}