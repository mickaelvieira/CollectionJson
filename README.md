# Json Collection

PHP implementation of the Collection+JSON Media Type

Specification: 
- [http://amundsen.com/media-types/collection/](http://amundsen.com/media-types/collection/)

## Installation

JsonCollection requires php >= 5.4

Install JsonCollection with [Composer](https://getcomposer.org/)

```json
{
    "require": {
        "mvieira/json-collection": "dev-master"
    }
}
```

## Contributing

```sh
$ git clone git@github.com:mickaelvieira/JsonCollection.git
$ cd JsonCollection
$ composer install
```

### Run the test

The test suite has been written with [PHPSpec](http://phpspec.net/)

```sh
./bin/phpspec run
```

### PHP Code Sniffer

This project follows the coding style guide [PSR2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

```sh
$ ./bin/phpcs --standard=PSR2 ./src/
```

## Documentation

### Creating a collection

```php
use JsonCollection\Entity\Collection;
use JsonCollection\Entity\Item;

$collection = new Collection();

$item = new Item();
$item->setHref('/item/1');

$collection->addItem($item);

print json_encode($collection);
```

```json
{
    "collection": {
        "version": "1.0",
        "items": [
            {
                "href": "/item/1"
            }
        ]
    }
}
```

### Printing the data

Note: Apart from the data's value property, which allows having a NULL value (see. [specification](http://amundsen.com/media-types/collection/format/#properties-value)), All ```NULL``` properties and empty arrays will be excluded from the JSON and Array representation.

#### Printing a JSON representation

All entities implement the [JsonSerializable](http://php.net/manual/en/class.jsonserializable.php) interface,
you can therefore call at any time the method ```json_encode()```.

```php
print json_encode($collection);
```

```json
{
    "collection": {
        "version": "1.0",
        "items": [
            ...
        ],
        "links": [
            ...
        ]
    }
}
```

#### Printing an Array representation

All entities implement a custom interface named ```ArrayConvertible```, so you can call at any time the method ```toArray()```.
This method will be called recursively on all nested entities.

```php
print_r($collection->toArray());
```

```php
Array
(
    [collection] => Array
        (
            [version] => 1.0
            [items] => Array
                ...

            [links] => Array
                ...

        )

)
```

#### Adding an envelope

The ```JsonCollection\Entity\Collection``` entity will be wrapped within an envelope...

```php
echo json_encode($collection);
```

```json
{
    "collection": {
        "version": "1.0"
     }
}
```
...however others entities will not be wrapped within an envelope when they are converted in a JSON or an Array.

```php
$template = new Template();
echo json_encode($template);
```

```json
{
    "data": [
        ...
    ]
}
```

But you can add an envelope to the json and array representation by calling the method ```setEnvelope()```

```php
$template->setEnvelope('template');
echo json_encode($template);
```

```json
{
    "template": {
        "data": [
            ...
        ]
    }
}
```
### Creating an entity

All entities can be created by passing an array in the constructor...

```php
$data = new Data([
    'name' => 'email',
    'value' => 'email value'
]);
```

...or inject the data later on...

```php
$data = new Data();
$data->inject([
    'name' => 'email',
    'value' => 'email value'
]);
```

...or by using the accessors.

```php
$data = new Data();
$next->setName('email');
$next->setValue('email value');
```

#### Collection

[http://amundsen.com/media-types/collection/format/#objects-collection](http://amundsen.com/media-types/collection/format/#objects-collection)

```php
use JsonCollection\Entity\Collection;
use JsonCollection\Entity\Item;
use JsonCollection\Entity\Query;
use JsonCollection\Entity\Error;
use JsonCollection\Entity\Template;
use JsonCollection\Entity\Link;

$collection = new Collection();
$collection->setHref('http://www.example.com');

$collection->addItem(new Item());
$collection->addItems([
    new Item(),
    new Item()
]);

$collection->addLink(new Link());
$collection->addLinkSet([
    new Link(),
    new Link()
]);

$collection->addQuery(new Query());
$collection->addQueries([
    new Query(),
    new Query()
]);

$collection->setError(new Error());
$collection->setTemplate(new Template());
```

#### Item

[http://amundsen.com/media-types/collection/format/#arrays-items](http://amundsen.com/media-types/collection/format/#arrays-items)

```php
use JsonCollection\Entity\Item;
use JsonCollection\Entity\Data;
use JsonCollection\Entity\Link;

$item = new Item();
$item->setHref('http://www.example.com');

$item->addData(new Data());
$item->addDataSet([
    new Data(),
    new Data()
]);

$item->addLink(new Link());
$item->addLinkSet([
    new Link(),
    new Link()
]);

```

#### Link

[http://amundsen.com/media-types/collection/format/#arrays-links](http://amundsen.com/media-types/collection/format/#arrays-links)

```php
use JsonCollection\Entity\Link;
use JsonCollection\Entity\Type\Render;
use JsonCollection\Entity\Type\Relation;

$link = new Link();
$link->setName('link name');
$link->setHref('http://www.example.com');
$link->setPrompt('prompt value');
$link->setRel(Relation::ITEM);
$link->setRender(Render::IMAGE); // default Render::LINK
```

#### Query

[http://amundsen.com/media-types/collection/format/#arrays-queries](http://amundsen.com/media-types/collection/format/#arrays-queries)

```php
use JsonCollection\Entity\Query;
use JsonCollection\Entity\Data;
use JsonCollection\Entity\Type\Relation;

$query = new Query();
$query->setHref('http://www.example.com');
$query->setRel(Relation::SEARCH);
$query->setName('value');
$query->setPrompt('value');

$query->addData(new Data());
$query->addDataSet([
    new Data(),
    new Data()
]);
```

#### Error

[http://amundsen.com/media-types/collection/format/#objects-error](http://amundsen.com/media-types/collection/format/#objects-error)

```php
use JsonCollection\Entity\Error;

$error = new Error();
$error->setTitle('error title');
$error->setCode('error code');
$error->setMessage('error message');
```

#### Template

[http://amundsen.com/media-types/collection/format/#objects-template](http://amundsen.com/media-types/collection/format/#objects-template)

```php
use JsonCollection\Entity\Template;
use JsonCollection\Entity\Data;

$template = new Template();

$template->addData(new Data());
$template->addDataSet([
    new Data(),
    new Data()
]);

```

#### Data

[http://amundsen.com/media-types/collection/format/#arrays-data](http://amundsen.com/media-types/collection/format/#arrays-data)

```php
use JsonCollection\Entity\Data;
use JsonCollection\Entity\ListData;
use JsonCollection\Entity\Option;
use JsonCollection\Entity\Type\Input;

$data = new Data();
$data->setName('data name');
$data->setPrompt('data prompt');
$data->setValue('data value');
```

### Working with data and links

In order to work with JsonCollection Arrays [Data](http://amundsen.com/media-types/collection/format/#arrays-data), [Links](http://amundsen.com/media-types/collection/format/#arrays-links), the API provides 2 interfaces that implement the same logic.

- The interface ```DataAware``` implemented by ```Item```, ```Query``` and ```Template``` entities,
provides the methods ```addData```, ```addDataSet``` and ```getDataSet```
- The interface ```LinkAware``` implemented by ```Collection``` and ```Item``` entities,
provides the methods```addLink```, ```addLinkSet``` and ```getLinkSet```

They allows you to add the corresponding entities to objects that implement them.

```php
$item = new Item();

// this...
$item->addData([
    'name' => 'email',
    'value' => 'email value'
]);

// ...is similar to 
$data = new Data([
    'name' => 'email',
    'value' => 'email value'
]);
$item->addData($data);

// and that...
$item->addDataSet([
    [
        'name' => 'email',
        'value' => 'email value'
    ],
    [
        'name' => 'tel',
        'value' => 'tel value'
    ]
]);

// ...is similar to 
$data1 = new Data([
    'name' => 'email',
    'value' => 'email value'
]);
$data2 = new Data([
    'name' => 'tel',
    'value' => 'tel value'
]);
$item->addDataSet([
    $data1,
    $data2
]);
```

