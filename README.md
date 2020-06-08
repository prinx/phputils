# PHP Utils

PHP Utilities classes

## Installation

```shell
composer require prinx/phputils:dev-master
```
## Usage
Import the composer autoload file:
```php
require_once 'path/to/vendor/autoload.php';
```
Then you can _use_ the needed utility class:
```php
use Prinx\Utils\Date;

echo Str::isMaxLength('Woow', 5); // true
```
## Utilities classes
Each utility class provides a set of static methods.

### Str: string utilities
Check the available string processing methods [here](https://github.com/Prinx/phputils/edit/master/src/Str.php).
### Date: date utilities
Check the available string processing methods [here](https://github.com/Prinx/phputils/edit/master/src/Date.php).
### HTTP: HTTP utilities
Check the available string processing methods [here](https://github.com/Prinx/phputils/edit/master/src/HTTP.php).
### URL: URL utilities
Check the available string processing methods [here](https://github.com/Prinx/phputils/edit/master/src/URL.php).
### SMS: sms utilities
Check the available string processing methods [here](https://github.com/Prinx/phputils/edit/master/src/SMS.php).

