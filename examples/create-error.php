<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Error;

$error = (new Error())
    ->withTitle('error title')
    ->withCode('error code')
    ->withMessage('error message');

echo json_encode($error, JSON_PRETTY_PRINT);
