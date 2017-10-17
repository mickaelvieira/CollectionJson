<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Data;

$data = (new Data('data name'))
    ->withPrompt('data prompt')
    ->withValue('data value');

echo json_encode($data, JSON_PRETTY_PRINT);
