# PHP Utils

PHP Utilities classes

## Installation

```shell
composer require prinx/phputils
```
## Usage
Import the composer autoload file:
```php
require_once 'path/to/vendor/autoload.php';
```
Then you can _use_ the needed utility class:
```php
use Prinx\Utils\Str;

echo Str::isMaxLength('Woow', 5); // true
```
## Utilities classes
Each utility class provides a set of static methods.

### Str
Check the available methods [here](https://github.com/Prinx/phputils/edit/master/src/Str.php).

### Date
Check the available methods [here](https://github.com/Prinx/phputils/edit/master/src/Date.php).

### HTTP
Check the available methods [here](https://github.com/Prinx/phputils/edit/master/src/HTTP.php).

### URL
Check the availableg methods [here](https://github.com/Prinx/phputils/edit/master/src/URL.php).

### SMS
Check the available methods [here](https://github.com/Prinx/phputils/edit/master/src/SMS.php).

