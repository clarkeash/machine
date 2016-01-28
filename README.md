# Machine
Machine helps you create php classes, interfaces and more

[![Author](http://img.shields.io/badge/author-@clarkeash-blue.svg?style=flat-square)](https://twitter.com/clarkeash)
[![Travis](https://img.shields.io/travis/clarkeash/machine.svg?style=flat-square)](https://travis-ci.org/clarkeash/machine)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/clarkeash/machine.svg?style=flat-square)](https://scrutinizer-ci.com/g/clarkeash/machine)
[![Codecov](https://img.shields.io/codecov/c/github/clarkeash/machine.svg?style=flat-square)](https://codecov.io/github/clarkeash/machine)
[![Packagist Version](https://img.shields.io/packagist/v/clarkeash/machine.svg?style=flat-square)](https://packagist.org/packages/clarkeash/machine)
[![License](https://img.shields.io/packagist/l/clarkeash/machine.svg?style=flat-square)](https://github.com/clarkeash/machine/blob/master/LICENSE)

## Installation

```bash
composer global require clarkeash/machine
```

## Usage

This package requires that you have psr-4 autoloading enabled in your composer.json file, as this is how it calculates the namespace for the classes you create.

The machine command should be ran from the root directory, where the composer.json lives.

#### Class

Create a basic class

```bash
machine make:class Example
```

Create an abstract class

```bash
machine make:class Example --abstract
```

#### Interface

Create an interface

```bash
machine make:interface ExampleInterface
```

#### Trait

Create a trait

```bash
machine make:trait ExampleTrait
```

## Testing

``` bash
./vendor/bin/phpunit
```

##License

This package is released under the MIT license. Please see the [License File](LICENSE) for more information.
