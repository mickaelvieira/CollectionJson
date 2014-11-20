# Json Collection

PHP implementation of the Collection+JSON Media Type

Specification: 
- [http://amundsen.com/media-types/collection/](http://amundsen.com/media-types/collection/)

## Installation

JsonCollection requires php >= 5.4

Install JsonCollection with [Composer](https://getcomposer.org/):

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

See the [entities documentation](entities.md) for the detail of each entity.

### Working with data and links

In order to work with JsonCollection Arrays [Data](http://amundsen.com/media-types/collection/format/#arrays-data), [Links](http://amundsen.com/media-types/collection/format/#arrays-links), [Options](http://code.ge/media-types/collection-next-json/#array-options) and [Messages](http://code.ge/media-types/collection-next-json/#array-messages) the API provides 4 interfaces that implement the same logic.

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

