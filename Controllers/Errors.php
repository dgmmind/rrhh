<?php
class Errors extends Controllers
{
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * @throws Exception
     */
    public function notFound(): void
    {
        $this->views->getViews($this,"errors");
    }
}
$notFound = new Errors();
try {
    $notFound->notFound();
} catch (Exception $e) {
    echo $e->getMessage();
}