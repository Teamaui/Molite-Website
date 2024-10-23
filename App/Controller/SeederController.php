<?php

namespace Controller;

use Seeder\MasterSeeder;

class SeederController
{

    private MasterSeeder $masterSeeder;

    public function __construct()
    {
        $this->masterSeeder = new MasterSeeder();
    }

    public function run(): void
    {
        $this->masterSeeder->run();
    }

    public function rollback(): void
    {
        $this->masterSeeder->rollback();
    }

    public function rerun(): void
    {
        $this->masterSeeder->rollback();
        $this->masterSeeder->run();
    }
}
