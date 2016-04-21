<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use CollectionJson\Entity\Data;

$data = (new Data())
    ->setName('data name')
    ->setPrompt('data prompt')
    ->setValue('data value');

echo json_encode($data, JSON_PRETTY_PRINT);
