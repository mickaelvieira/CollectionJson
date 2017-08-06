# Collection Json

[![Software License](https://img.shields.io/github/license/mashape/apistatus.svg)](https://github.com/mickaelvieira/CollectionJson/blob/master/LICENSE.md)
[![Latest Stable Version](https://img.shields.io/packagist/v/mvieira/collection-json.svg)](https://packagist.org/packages/mvieira/collection-json)
[![Build Status](https://travis-ci.org/mickaelvieira/CollectionJson.svg?branch=master)](https://travis-ci.org/mickaelvieira/CollectionJson)
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
        "mvieira/collection-json": "dev-master"
    }
}
```
or

```sh
$ composer require mvieira/collection-json
```

## Contributing

Please see [CONTRIBUTING](https://github.com/mickaelvieira/CollectionJson/tree/master/CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](https://github.com/mickaelvieira/CollectionJson/tree/master/LICENSE) for more information.

## Documentation

### Creating a collection

```php
$collection = (new Collection())
    ->withItem((new Item())
        ->withHref('https://example.co/item/1')
        ->withDataSet([
            new Data('data 1'),
            new Data('data 2', 'value 2')
        ])
        ->withLink(
            new Link('https://example.co/item/1', Relation::ITEM)
        )
    );

print json_encode($collection);
```

```json
{
    "collection": {
        "version": "1.0",
        "items": [
            {
                "data": [
                    {
                        "name": "data 1",
                        "value": null
                    },
                    {
                        "name": "data 2",
                        "value": "value 2"
                    }
                ],
                "href": "http:\/\/example.com\/item\/1",
                "links": [
                    {
                        "href": "https:\/\/example.co\/item\/1",
                        "rel": "item",
                        "render": "link"
                    }
                ]
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
    'value' => 'hello@example.co'
]);
```

...or by using the accessors (Note that entities are immutable)

```php
$data = (new Data())
    ->withName('email')
    ->withValue('hello@example.co');
```

...or via the constructor

```php
$data = new Data('email', 'hello@example.co');
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

In order to work with CollectionJson Arrays [Data](http://amundsen.com/media-types/collection/format/#arrays-data), [Links](http://amundsen.com/media-types/collection/format/#arrays-links), the API provides 2 interfaces that implement a similar logic.

- The interface ```DataAware``` implemented by ```Item```, ```Query``` and ```Template``` entities,
provides the methods ```withData```, ```withoutData```, ```withDataSet```, ```getDataSet```, ```getFirstData``` and ```getLastData```
- The interface ```LinkAware``` implemented by ```Collection``` and ```Item``` entities,
provides the methods ```withLink```, ```withoutLink```, ```withLinkSet```, ```getLinks```, ```getFirstLink``` and ```getLastLink```

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
        new Data('email', 'hello@example.co'),
        new Data('tel', '0000000000')
    ]);

// ...is similar to
$data1 = Data::fromArray([
    'name' => 'email',
    'value' => 'hello@example.co'
]);
$data2 = Data::fromArray([
    'name' => 'tel',
    'value' => '0000000000'
]);
$item = (new Item())
    ->withDataSet([
        $data1,
        $data2
    ]);
```

### Validation

It is now possible to validate the data entering your API by using the [Symfony validator](https://symfony.com/doc/current/components/validator.html).

```php
use CollectionJson\Validator\Dataset as DatasetValidator;
use Symfony\Component\Validator\Constraints;

$constraints = [
    'id' => [
        new Constraints\NotBlank(),
    ],
    'url' => [
        new Constraints\NotBlank(),
        new Constraints\Url(),
    ],
    'email' => [
        new Constraints\NotBlank(),
        new Constraints\Email(),
    ],
];

$template = (new Template())
    ->withData(new Data('id', '123'))
    ->withData(new Data('url', 'http://example.co'))
    ->withData(new Data('email', 'test@example.co'));

$errors = (new DatasetValidator())
    ->validate($template->getDataSet(), $constraints);
```

It will return the list of errors.
