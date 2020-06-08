# PHP Utils

PHP Utilities classes

## Installation

```shell
composer require prinx/phputils:dev-master
```
## USAGE
Import the composer autoload file:
```php
require_once 'path/to/vendor/autoload.php';
```
Then you can _use_ the needed utility class:
```php
use Prinx\Utils\Date;

echo Str::isMaxLength('Woow', 5); // true
```
