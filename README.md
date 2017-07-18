# Collection Json

[![Build Status](https://travis-ci.org/mickaelvieira/CollectionJson.svg?branch=master)](https://travis-ci.org/mickaelvieira/CollectionJson)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://github.com/mickaelvieira/CollectionJson/blob/master/LICENSE)
[![Coverage Status](https://coveralls.io/repos/github/mickaelvieira/CollectionJson/badge.svg?branch=master)](https://coveralls.io/github/mickaelvieira/CollectionJson?branch=master)

PHP implementation of the Collection+JSON Media Type

Specification: 
- [http://amundsen.com/media-types/collection/](http://amundsen.com/media-types/collection/)

## Installation

CollectionJson requires php >= 7.0

Install CollectionJson with [Composer](https://getcomposer.org/)

```json
{
    "require": {
        "mvieira/json-collection": "dev-master"
    }
}
```

## Contributing

Please see [CONTRIBUTING](https://github.com/mickaelvieira/CollectionJson/tree/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/mickaelvieira/CollectionJson/tree/master/LICENSE) for more information.

## Documentation

### Creating a collection

```php
use CollectionJson\Entity\Collection;
use CollectionJson\Entity\Item;

$item = (new Item())
    ->setHref('http://example.com/item/1');

$collection = new Collection()
    ->withItem($item);

print json_encode($collection);
```

```json
{
    "collection": {
        "version": "1.0",
        "items": [
            {
                "href": "http://example.com/item/1"
            }
        ]
    }
}
```

### Creating an entity

All entities ```Collection```, ```Data```, ```Error```, ```Item```, ```Link```, ```Query```, ```Template``` can be created by using the static method ```fromArray```...

```php
$data = Data::fromArray([
    'name' => 'email',
    'value' => 'email value'
]);
```

...or by using the mutators.

```php
$data = (new Data())
    ->withName('email')
    ->withValue('email value');
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

#### Wrapping

The ```CollectionJson\Entity\Collection``` entity will be wrapped...

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
...however others entities will not be wrapped when they are converted in a JSON or an Array.

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

But you can wrap the json or the array representation by calling the method ```wrap()```

```php
$template->wrap();
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

### Examples

Examples are available in the directory ```./examples/```, you can execute them on the command line by running:

```sh
$ ./bin/test-example
```

Or separately
```
$ php ./examples/client-collection.php
```

### Working with data and links

In order to work with CollectionJson Arrays [Data](http://amundsen.com/media-types/collection/format/#arrays-data), [Links](http://amundsen.com/media-types/collection/format/#arrays-links), the API provides 2 interfaces that implement the same logic.

- The interface ```DataAware``` implemented by ```Item```, ```Query``` and ```Template``` entities,
provides the methods ```addData```, ```addDataSet```, ```getDataSet```, ```getFirstData``` and ```getLastData```
- The interface ```LinkAware``` implemented by ```Collection``` and ```Item``` entities,
provides the methods```addLink```, ```addLinkSet```, ```getLinkSet```, ```getFirstLink``` and ```getLastLink```

They allows you to add the corresponding entities to objects that implement them.

```php
// this...
$item = (new Item())
    ->withData([
        'name' => 'email',
        'value' => 'email value'
    ]);

// ...is similar to 
$data = Data::fromArray([
    'name' => 'email',
    'value' => 'email value'
]);

$item = (new Item())
    ->withData($data);

// and that...
$item = (new Item())
    ->withDataSet([
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
$data1 = Data::fromArray([
    'name' => 'email',
    'value' => 'email value'
]);
$data2 = Data::fromArray([
    'name' => 'tel',
    'value' => 'tel value'
]);
$item = (new Item())
    ->withDataSet([
        $data1,
        $data2
    ]);
```

