<?php

require_once __DIR__ . '/../src/Core/Database.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Services/AuthService.php';

use Src\Services\AuthService;

$auth = new AuthService();

$result = $auth->login(
    'admin@test.com',
    'password123'
);

echo '<pre>';
print_r($result);
echo '</pre>';
