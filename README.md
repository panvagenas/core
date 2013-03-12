# WebSharks™ Core

##### The WebSharks™ Core framework (for WordPress®)

The WebSharks™ Core can be bundled into plugins created for WordPress®. It is most often distributed as a single GZIP compressed [PHP Archive](http://www.php.net/manual/en/intro.phar.php) file; found inside `/websharks-core.phar.php`. This file not only contains the entire WebSharks™ Core; but it is also a [webPhar-compatible archive](http://php.net/manual/en/phar.webphar.php) capable of serving both static and dynamic content through popular web servers like Apache®, Litespeed™, Windows® IIS; and other Apache-compatible web servers.

### Incorporating the WebSharks™ Core into a plugin for WordPress®

#### There are two options available...

##### Option #1. Using a GZIP compressed PHP Archive (recommended for easy redistribution).

Redistribute your plugin with this single file (`/websharks-core.phar.php`); which can be obtained from the repo here at GitHub™. To make use of the WebSharks™ Core, add these lines of PHP code to files that depend on the WebSharks™ Core.

```php
<?php
// The WebSharks™ Core.
include_once 'websharks-core.phar.php';

// Example usage...
$wsc = websharks_core();
echo $wsc->©var->dump($wsc->©classes->get_details());
```
*It is important to note that while the `websharks-core.phar.php` file is rather large; including the file in a PHP script does NOT actually include the entire PHP Archive; because the `websharks-core.phar.php` file halts the PHP compiler after the initial PHP Archive stub is loaded into your scripts. In other words, it is perfectly safe (and efficient) to include `websharks-core.phar.php` in your plugin files.*

*WebSharks™ Core class methods/properties that you access in your PHP scripts will be autoloaded by the WebSharks™ Core (only as needed; and this occurs automatically at runtime) — keeping your application highly effecient at all times. The WebSharks™ Core uses PHP's SPL Autoload functionality to accomplish this dynamically for you.*

---

##### Option #2. Bundling the entire WebSharks™ Core (full directory structure).

Download the full directory structure from the repo here at GitHub™ (use ZIP download option). You will need to bundle the entire `websharks-core/` directory into your plugin; including it right along with all of the other files that make up your plugin. To make use of the WebSharks™ Core, add these lines of PHP code to files that depend on the WebSharks™ Core.

```php
<?php
// The WebSharks™ Core.
include_once 'websharks-core/stub.php';

// Example usage...
$wsc = websharks_core();
echo $wsc->©var->dump($wsc->©classes->get_details());
```
*While the `websharks-core/` directory is rather large; including the `stub.php` in a PHP script does NOT actually include the entire class structure of the WebSharks™ Core. WebSharks™ Core class methods/properties that you access in your PHP scripts will be autoloaded by the WebSharks™ Core (only as needed; and this occurs automatically at runtime) — keeping your application highly effecient at all times. The WebSharks™ Core uses PHP's SPL Autoload functionality to accomplish this dynamically for you.*

