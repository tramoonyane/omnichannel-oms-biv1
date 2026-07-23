<?php

namespace Src\Controllers;

use Src\Services\Presentation\DashboardService;
use Psr\Http\Message\ServerRequestInterface as Request;

class DashboardController
{
    private DashboardService $service;


    public function __construct(DashboardService $service)
    {
        $this->service = $service;
    }


    public function summary(Request $request): array
    {
        $user = $request->getAttribute('user');

        return $this->service->getSummary(
            $user['role']
        );
    }
}