<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use CollectionJson\Entity\Error;

$error = (new Error())
    ->setTitle('error title')
    ->setCode('error code')
    ->setMessage('error message');

echo json_encode($error, JSON_PRETTY_PRINT);
