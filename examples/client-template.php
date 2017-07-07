<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
$json = file_get_contents(__DIR__ . '/fixtures/template.json');

use CollectionJson\Entity\Template;

$template = Template::fromJson($json);

echo 'Data set size: ' . count($template->getDataSet()) . "\n";

echo "Template:\n";
/** @var \CollectionJson\Entity\Data $data */
foreach ($template->getDataSet() as $data) {
    echo "\tData:\n";
    echo "\t\t NAME: " . $data->getName() . "\n";
    echo "\t\t VALUE: " . $data->getValue() . "\n";
}
