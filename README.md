# WebSharks™ Core

##### The WebSharks™ Core framework (for WordPress®)

The WebSharks™ Core can be bundled into plugins created for WordPress®. It is most often distributed as a single GZIP compressed [PHP Archive](http://www.php.net/manual/en/intro.phar.php) file; found inside `/websharks-core.phar.php`. This file not only contains the entire WebSharks™ Core; but it is also a [webPhar-compatible archive](http://php.net/manual/en/phar.webphar.php) capable of serving both static and dynamic content through popular web servers like Apache®, Litespeed™, Windows® IIS; and other Apache-compatible web servers.

### Incorporating the WebSharks™ Core into a plugin for WordPress®

#### There are two options available...

##### Option #1. Using a GZIP compressed PHP Archive (recommended for small plugins).

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

---

### Creating a New WP Plugin Based on the WebSharks™ Core

Create this test plugin directory and file: `/wp-content/plugins/rocketship/plugin.php`

```php
<?php
namespace rocketship;

/*
For WordPress®
Plugin Name: RocketShip™
See also: http://codex.wordpress.org/File_Header
*/

// Include the plugin you're about to create.
include_once dirname(__FILE__).'/classes/framework.php';
```

Now create this directory and file: `/wp-content/plugins/rocketship/classes/framework.php`

```php
<?php
namespace rocketship;

// Include your bundled copy of the WebSharks™ Core.
// Assuming: `/wp-content/plugins/rocketship/websharks-core.phar.php`.
include_once dirname(dirname(__FILE__)).'/websharks-core.phar.php';

// Tell the WebSharks™ Core Autoloader about your PHP classes.
\websharks_core_autoloader::add_classes_dir(dirname(__FILE__));
\websharks_core_autoloader::add_root_ns(__NAMESPACE__);

class framework extends \websharks_core
{
  // This will serve as the base class for your plugin.
}

$GLOBALS[__NAMESPACE__] = new framework(
	array(
	     'plugin_root_ns'        => __NAMESPACE__, // The root namespace (e.g. rocketship).
	     'plugin_var_ns'         => __NAMESPACE__, // A shorter namespace alias (if you like).
	     'plugin_name'           => 'RocketShip™', // The name of your plugin (pretty print).
	     'plugin_version'        => '130310', // Version of your plugin (must be YYMMDD format).
	     'plugin_site'           => 'http://www.example.com/rocketship-plugin', // URL to plugin site.
	     'dynamic_class_aliases' => array(), // We'll get into this in a later tutorial; just use an empty array.

	     'plugin_dir'            => dirname(__FILE__) // Your plugin directory.
	     /* This directory MUST contain a WordPress® plugin file w/ name: `plugin.php`.
	      * If you have this plugin directory: `/wp-content/plugins/rocketship/`
	      * This file MUST exist: `/wp-content/plugins/rocketship/plugin.php` */
	)
); $GLOBALS[__NAMESPACE__]->©plugin->load();
```

#### A quick test now (after installing your plugin).

```php
echo $rocketship->©var->dump($rocketship);
```

#### Creating new class files that extend your framework (optional).

Create this directory and file:
`/wp-content/plugins/rocketship/classes/blaster.php`

```php
<?php
namespace rocketship;
class blaster extends framework
{
  public function says()
		{
			$output = 'Hello :-)'."\n";
			$output .= $this->©var->dump($this);
			return $output;
		}
}
```

#### A quick test now.

```php
echo $rocketship->©blaster->says();
```

---

### Why Base My Plugin on the WebSharks™ Core?

The WebSharks™ Core makes plugin development SUPER easy. Everything from installation, to options, to database interactity; along with MANY utilities that can make development much easier for you. We'll get into additional examples soon :-)