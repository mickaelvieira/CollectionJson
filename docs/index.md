# JsonCollection

PHP implementation of the Collection.next+JSON Media Type

## Installation

Install JsonCollection with [Composer](https://getcomposer.org/):

```json
{
    "require": {
        "mvieira/json-collection": "dev-master"
    }
}
```

## Get Started

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

## Printing the data

### Printing a JSON representation

All entities implement the [JsonSerializable](http://php.net/manual/en/class.jsonserializable.php) interface,
you can therefore call at any time the method ```json_encode()```.
This method will be recursively called on all nested entities.

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

### Printing an Array representation

All entities implement a custom interface ```ArrayConvertible```,
you can therefore call at any time the method ```toArray()```.
This method will be recursively called on all nested entities.

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

### Adding an envelope

The ```JsonCollection\Entity\Collection``` entity will be by default wrapped within an envelope.

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
Others entities will not be wrapped within an envelope.

```php
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

## Creating an entity

All entities can be created by passing an array in the constructor...

```php
$data = new Data([
    'name' => 'email',
    'value' => 'email value'
]);
```

...or by using the accessors

```php
$data = new Data();
$next->setName('email');
$next->setValue('email value');
```

See the [entities documentation](https://github.com/mickaelvieira/JsonCollection/blob/master/docs/entities.md) for the detail of each entity.

## Working with data, links and options

- The interface ```DataAware``` implemented by ```Item```, ```Query``` and ```Template``` entities,
provides the methods ```addData``` and ```addDataSet```

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

- The interface ```LinkAware``` implemented by ```Collection``` and ```Item``` entities,
provides the methods```addLink``` and ```addLinkSet```

```php
$collection = new Collection();

// this...
$collection->addLink([
    'href' => 'uri',
    'rel' => 'prev'
]);

// ...is similar to 
$link = new Link([
    'href' => 'uri',
    'rel' => 'prev'
]);
$collection->addLink($link);

// and that...
$collection->addLinkSet([
    [
        'href' => 'uri',
        'rel' => 'prev'
    ],
    [
        'href' => 'uri',
        'rel' => 'next'
    ]
]);

// ...is similar to 
$link1 = new Link([
    'href' => 'uri',
    'rel' => 'prev'
]);
$link2 = new Link([
    'href' => 'uri',
    'rel' => 'next'
]);
$collection->addLinkSet([
    $link1,
    $link2
]);
```

- The interface ```OptionAware``` implemented by ```Enctype```, ```ListData``` and ```Method``` entities,
provides the methods ```addOption``` and ```addOptionSet```

```php
$list = new ListData();

// this...
$list->addOption([
    'prompt' => 'option prompt',
    'value' => 'option value'
]);

// ...is similar to 
$option = new Option([
    'prompt' => 'option prompt',
    'value' => 'option value'
]);
$list->addOption($option);

// and that...
$list->addOptionSet([
    [
        'prompt' => 'option 1 prompt',
        'value' => 'option 1 value'
    ],
    [
        'prompt' => 'option 2 prompt',
        'value' => 'option 2 value'
    ]
]);

// ...is similar to 
$option1 = new Option([
    'prompt' => 'option 1 prompt',
    'value' => 'option 1 value'
]);
$option2 = new Option([
    'prompt' => 'option 2 prompt',
    'value' => 'option 2 value'
]);
$list->addOptionSet([
    $option1,
    $option2
]);
```