<?php
declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
$json = file_get_contents(__DIR__ . '/fixtures/collection.json');

use CollectionJson\Entity\Collection;

$collection = Collection::fromJson($json);

echo "\nHREF: " . $collection->getHref() . "\n";

if ($collection->hasLinks()) {
    echo "First Link: \n";
    echo "\t" . $collection->getFirstLink()->getHref() . "\n";
    echo "Last Link: \n";
    echo "\t" . $collection->getLastLink()->getHref() . "\n";
}
if ($collection->hasItems()) {
    echo "Items:\n";
    /** @var \CollectionJson\Entity\Item $item */
    foreach ($collection->getItemsSet() as $item) {
        echo "\tItem:\n";
        echo "\t\t First link: " . $item->getFirstLink()->getHref() . "\n";
        echo "\t\t First data: " . $item->getFirstData()->getName() . ' ' . $item->getFirstData()->getValue() . "\n";
    }
}
if ($collection->hasQueries()) {
    echo "Queries:\n";
    /** @var \CollectionJson\Entity\Query $query */
    foreach ($collection->getQueriesSet() as $query) {
        echo "\tQuery:\n";
        echo "\t\t HREF: " . $query->getHref() . "\n";
        echo "\t\t PROMPT: " . $query->getPrompt() . "\n";
    }
}
if ($collection->hasTemplate()) {
    echo "Template:\n";
    /** @var \CollectionJson\Entity\Data $data */
    foreach ($collection->getTemplate()->getDataSet() as $data) {
        echo "\tData:\n";
        echo "\t\t NAME: " . $data->getName() . "\n";
        echo "\t\t VALUE: " . $data->getValue() . "\n";
    }
}

if ($collection->hasError()) {
    echo "Error:\n";
    echo "\t\t TITLE: " . $collection->getError()->getTitle() . "\n";
    echo "\t\t CODE: " . $collection->getError()->getCode() . "\n";
    echo "\t\t MESSAGE: " . $collection->getError()->getMessage() . "\n";
}
