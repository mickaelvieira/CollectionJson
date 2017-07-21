<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use CollectionJson\Entity\Template;
use CollectionJson\Entity\Data;

$template = (new Template())
    ->withData(new Data('string', ''))
    ->withData(new Data('null', null))
    ->withData(new Data('integer', 0))
    ->withData(new Data('float', 0.2))
    ->withData(new Data('boolean', false))
    ->wrap();

echo json_encode($template, JSON_PRETTY_PRINT);
