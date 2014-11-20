# Json Collection

PHP implementation of the Collection+JSON Media Type

Specification: 
- [http://amundsen.com/media-types/collection/](http://amundsen.com/media-types/collection/)

## Documentation

The latest documentation can be found [here](https://mickaelvieira.github.io/all-the-docs/json-collection/)
    
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

After running the tests, the code coverage report will be found in the directory ./coverage

### PHP Code Sniffer

This project follows the coding style guide [PSR2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)

```sh
$ ./bin/phpcs --standard=PSR2 ./src/
```
