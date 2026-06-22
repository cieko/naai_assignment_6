<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_once __DIR__ . '/includes/results-crud.php';

$conn = connection();

$page = $_GET['page'] ?? 'dashboard';

$allowedPages = [
    'dashboard',
    'add-result',
    'view-results'
];

if (!in_array($page, $allowedPages)) {
    http_response_code(404);
    exit('Page not found');
}

require __DIR__ . "/pages/{$page}.php";