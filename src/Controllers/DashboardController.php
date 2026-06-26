<?php

namespace Src\Controllers;

use Src\Services\Presentation\DashboardService;

class DashboardController
{
    private DashboardService $service;

    public function __construct()
    {
        $this->service = new DashboardService();
    }

    public function summary(): array
    {
        return $this->service->getSummary();
    }
}