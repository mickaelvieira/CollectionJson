# Entities reference

## Collection+Json types

### Collection

[http://amundsen.com/media-types/collection/format/#objects-collection](http://amundsen.com/media-types/collection/format/#objects-collection)

### Error

[http://amundsen.com/media-types/collection/format/#objects-error](http://amundsen.com/media-types/collection/format/#objects-error)

```php
$error = new Error();
$error->setTitle('error title');
$error->setCode('error code');
$error->setMessage('error message'); // use addMessage() to add a message as an object instead
```

### Template

[http://amundsen.com/media-types/collection/format/#objects-template](http://amundsen.com/media-types/collection/format/#objects-template)

### Item

[http://amundsen.com/media-types/collection/format/#arrays-items](http://amundsen.com/media-types/collection/format/#arrays-items)

```php
$item = new Item();
$item->setHref('/uri');
$item->addData(new Data());
$item->addLink(new Link());
```

### Data

[http://amundsen.com/media-types/collection/format/#arrays-data](http://amundsen.com/media-types/collection/format/#arrays-data)

```php
use JsonCollection\Data;
use JsonCollection\ListData;
use JsonCollection\Option;
use JsonCollection\Type\Input;

$data = new Data();
$data->setName('data name');
$data->setPrompt('data prompt');
$data->setValue('data value');
$data->setType(Input::DATETIME);
$data->setRequired(true);
$data->setList(new ListData());
$data->addOption(new Option()); // add option to the list
```

### Query

[http://amundsen.com/media-types/collection/format/#arrays-queries](http://amundsen.com/media-types/collection/format/#arrays-queries)

### Link

[http://amundsen.com/media-types/collection/format/#arrays-links](http://amundsen.com/media-types/collection/format/#arrays-links)

```php
use JsonCollection\Link
use JsonCollection\Type\Media;
use JsonCollection\Type\Render;
use JsonCollection\Type\Relation;

$link = new Link();
$link->setName('link name');
$link->setHref('/uri');
$link->setPrompt('prompt value');
$link->setRel(Relation::ITEM);
$link->setType(Media::JPEG);
$link->setRender(Render::IMAGE); // default Render::LINK
```

## Collection.next+Json types

### List

[http://code.ge/media-types/collection-next-json/#object-list](http://code.ge/media-types/collection-next-json/#object-list)

### Option

[http://code.ge/media-types/collection-next-json/#array-options](http://code.ge/media-types/collection-next-json/#array-options)

```php
use JsonCollection\Option

$option = new Option();
$option->setPrompt('option prompt');
$option->setValue('option value');
```

### Status

[http://code.ge/media-types/collection-next-json/#object-status](http://code.ge/media-types/collection-next-json/#object-status)

```php
use JsonCollection\Status

$status = new Status();
$status->setCode('status code');
$status->setMessage('status message');
```

### Method

[http://code.ge/media-types/collection-next-json/#object-method](http://code.ge/media-types/collection-next-json/#object-method)

```php
use JsonCollection\Option
use JsonCollection\Method

$option = new Option();
$method = new Method();
$method->addOption($option);
```

### Enctype

[http://code.ge/media-types/collection-next-json/#object-enctype](http://code.ge/media-types/collection-next-json/#object-enctype)

```php
use JsonCollection\Option
use JsonCollection\Enctype

$option = new Option();
$enctype = new Enctype();
$enctype->addOption($option);
```

### Message

[http://code.ge/media-types/collection-next-json/#array-messages](http://code.ge/media-types/collection-next-json/#array-messages)

```php
$error = new Error();
$error->setCode('error code');
$message = new Message([
    'code' => 'Code message',
    'name' => 'Name message',
    'message' => 'Error message'
]);
$error->addMessage($message); // use setMessage() to set a message as a string instead
```
