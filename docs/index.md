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

### Adding an envelope

Beside the ```JsonCollection\Entity\Collection``` entity will be by default wrapped within an envelope...

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
...others entities will not be wrapped within an envelope.

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

...or inject the data later on

```php
$data = new Data();
$data->inject([
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

See the [entities documentation](entities.md) for the detail of each entity.

## Working with data, links and options

In order to work with JsonCollection Arrays Data, Links, Options and Messages the API provides 4 interfaces that implement the same kind of logic.

- The interface ```DataAware``` implemented by ```Item```, ```Query``` and ```Template``` entities,
provides the methods ```addData```, ```addDataSet``` and ```getDataSet```
- The interface ```LinkAware``` implemented by ```Collection``` and ```Item``` entities,
provides the methods```addLink```, ```addLinkSet``` and ```getLinkSet```
- The interface ```OptionAware``` implemented by ```Enctype```, ```ListData``` and ```Method``` entities,
provides the methods ```addOption```, ```addOptionSet``` and ```getOptionSet```
- The interface ```MessageAware``` implemented by the ```Error``` entity,
provides the methods ```addMessage```, ```addMessageSet``` and ```getMessageSet```

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





