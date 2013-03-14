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

// Alternate syntax (if you like this better — no © symbol needed).
echo websharks_core::var()->dump(websharks_core::classes()->get_details());
```
*It is important to note that while the `websharks-core.phar.php` file is rather large; including the file in a PHP script does NOT actually include the entire PHP Archive; because the `websharks-core.phar.php` file halts the PHP compiler after the initial PHP Archive stub is loaded into your scripts. In other words, it is perfectly safe (and efficient) to include `websharks-core.phar.php` in your plugin files.*

*WebSharks™ Core class methods/properties that you access in your PHP scripts will be autoloaded by the WebSharks™ Core (only as needed; and this occurs automatically at runtime) — keeping your application highly effecient at all times. The WebSharks™ Core uses PHP's SPL Autoload functionality to accomplish this dynamically for you.*

---

##### Option #2. Bundling the entire WebSharks™ Core (full directory structure — better performance).

Download the full directory structure from the repo here at GitHub™ (use ZIP download option). You will need to bundle the entire `websharks-core/` directory into your plugin; including it right along with all of the other files that make up your plugin. To make use of the WebSharks™ Core, add these lines of PHP code to files that depend on the WebSharks™ Core.

```php
<?php
// The WebSharks™ Core.
include_once 'websharks-core/stub.php';

// Example usage...
$wsc = websharks_core();
echo $wsc->©var->dump($wsc->©classes->get_details());

// Alternate syntax (if you like this better — no © symbol needed).
echo websharks_core::var()->dump(websharks_core::classes()->get_details());
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

class framework extends \websharks_core_framework
{
  // This will serve as the base class for your plugin.
}

$GLOBALS[__NAMESPACE__] = new framework(
  array(
         'plugin_root_ns'        => __NAMESPACE__, // The root namespace (e.g. rocketship).
         'plugin_var_ns'         => 'rs', // A shorter/sweeter namespace alias (if you like).
         'plugin_name'           => 'RocketShip™', // The name of your plugin (pretty print).
         'plugin_version'        => '130310', // Version of your plugin (must be YYMMDD format).
         'plugin_site'           => 'http://www.example.com/rocketship-plugin', // URL to plugin site.
         'dynamic_class_aliases' => array(), // We'll get into this in a later tutorial; just use an empty array.

         'plugin_dir'            => dirname(dirname(__FILE__)) // Your plugin directory.
         /* This directory MUST contain a WordPress® plugin file named: `plugin.php`.
          * If you have this plugin directory: `/wp-content/plugins/rocketship/`
          * This file MUST exist: `/wp-content/plugins/rocketship/plugin.php` */
    )
);
```

#### A quick test now (after installing your plugin into WordPress®).

```php
<?php
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
<?php
echo $rocketship->©blaster->says();
```

---

### Why Base My Plugin on the WebSharks™ Core?

The WebSharks™ Core makes plugin development SUPER easy. Everything from installation, options, menu pages, UI enhancements; to database interactity and exception handling; along with MANY utilities that can make development much easier for you. We'll get into additional examples soon :-) Once the Codex is ready-to-go, it will make things a little simpler for everyone. That being said, extending the WebSharks™ Core classes in creative ways, is what makes this powerful. The source code is already very well documented. If you're feeling adventurous you can start learning ahead of time if you like.

### Digging Deeper into the WebSharks™ Core can be FUN :-)

Let's say you're navigating the WebSharks™ Core source code and you find it has a cool class file `/websharks-core/classes/strings.php`; with several methods you'd like to use. If you've built your plugin on the WebSharks™ Core; all of those methods are alreay available in your plugin. To call upon the `strings` class in your plugin, you simply use the `©` symbol (representing a dynamic class). It's a copyright symbol, but the WebSharks™ Core associates this symbol with dynamic class instances (singletons). It can also instantiate new class instances; but we'll get into that later.

##### Calling a method in the `strings` class.
```php
<?php
echo $rocketship->©strings->unique_id();
```

Almost all of the WebSharks™ Core classes are aliased too (with both singular and plural forms); so you can make your code a little easier to understand; depending on the way you're using a particular class; or on the way you're using a particular method in that class. I can use `©strings` by calling the class absolutely; or I can call it's alias `©string` to make things a little easier to read.

##### Example of this usage (singular and plural forms).

```php
<?php
$a = '0'; $b = array('hello'); $c = 'there';

if($rocketship->©strings->are_not_empty($a, $b, $c)) // false
	echo $a.' '.$b.' '.$c;

else if($rocketship->©string->is_not_empty($a)) // false
	echo $a; // This is empty.

else // First `string` that is NOT empty.
	echo $rocketship->©strings->not_empty_coalesce($a, $b, $c); # there
```

----

### What if I don't like the the `©` symbol? Is there another way?

The answer is both yes and no. It depends on how you plan to work with the WebSharks™ Core. If you want to work with things from an INSIDE-out approach, we recommend sticking to the default WebSharks™ Core syntax; because that is most efficient when working with class objects (i.e. from within class object members). The `©` symbol might seem odd at first, but it becomes second-nature in just a matter of minutes. Also, most editors will offer some form of auto-completion to make it easier for you to repeat when you're writing code. In addition, when you're working from the INSIDE (i.e. from class members), you really won't use the dynamic class `©` symbol that often.

On the other hand, if you plan to use the WebSharks™ Core mostly from the OUTSIDE, as we're doing here (e.g. you're NOT planning to write and/or extend many classes of your own); you will probably be MUCH more comfortable working with the alternatives we make available. Maybe you would even prefer to use them both together in different ways; depending on the type of code you're writing.

### Other Ways to Access Dynamic Class Instances

The WebSharks™ Core will automatically setup an API class for your plugin. You might find the API class is easier to work with. This class is created dynamically when you instantiate your framework object instance (i.e. `new framework()` as seen above). The name of this special API class will always match that of your root Namespace in PHP (`rocketship` in this example). However, instead of it being declared within your Namespace; it's declared globally (for easy access from any PHP script - just like a PHP function would be).

##### Here is a quick example (using static methods in your API class).

```php
<?php
$a = NULL;
if(rocketship::string()->is_not_empty($a))
	echo $a;
else throw rocketship::exception('code', $a, '$a is empty!');
```

##### Here is another example (using an instance of your API class; instead of static calls).

```php
<?php
$rocketship = new rocketship();

$a = NULL;
if($rocketship->string->is_not_empty($a))
	echo $a;
else throw $rocketship->exception('code', $a, '$a is empty!');
```

If you like this approach better, please feel free to use it. Even if you're not going to use it, you might find value in this approach (from a site owner's perspective); because it might be helpful if you need to offer code samples; offering ways for a site owner to interact with your plugin quite easily. This is PERFECT for that type of thing, because it's a simpler/cleaner syntax.

----

The WebSharks™ Core will also create a shorter alias for this API class, using your `plugin_var_ns` value (part of your initial instance configuration). In this example it was `rs`. That's pretty short, hopefully it's not too short. Be careful when you configure `plugin_var_ns`. You don't want to create a conflict if introduced into an application where there are many plugins living together.

##### Here is a quick example (using static methods in your API class alias).

```php
<?php
$a = NULL;
if(rs::string()->is_not_empty($a))
	echo $a;
else throw rs::exception('code', $a, '$a is empty!');
```

##### Here is another example (using an instance of your API class alias; instead of static calls).

```php
<?php
$rs = new rs();

$a = NULL;
if($rs->string->is_not_empty($a))
	echo $a;
else throw $rs->exception('code', $a, '$a is empty!');
```

----

### What if I don't like the way a particular method works? What if I want to add a new method of my own? Does the WebSharks™ Core make it easy for me to get creative with things?

Absolutely. You can either create an entirely new class (as shown in a previous example); or you can extend an existing WebSharks™ Core class. Here is how you would extend the `strings` class (one of MANY that come with the WebSharks™ Core).

Create this file in your plugin directory: `/wp-content/plugins/rocketship/classes/strings.php`

```php
<?php
namespace rocketship;

class strings extends \websharks_core_v000000_dev\strings

// Change v000000_dev to the version you're using.
// Please make sure you get the version right :-)

{
    public function write_line($line) // My new class member.
        {
            echo $line.'<br />';
        }
    public function write_p($paragraph) // Another new member.
        {
            echo '<p>'.$paragraph.'</p>';
        }
    public function is_not_empty(&$var) // Overwrites existing class member.
        {
            return (!empty($var) && is_string($var));
        }
    public function markdown($string) // Another new member (w/ `$this` examples).
        {
            $this->check_arg_types('string:!empty', func_get_args());

            $string = $this->trim($string);

            echo $this->©markdown->parse($string);
        }
}
```

##### Now you have some new class members to work with.

```php
$line = 'I love to write code at GitHub.';
rocketship::string()->write_line($line);
```

```php
$line = 'I love to write code at GitHub.';
rocketship::string()->write_p($line);
```

```php
$line = 'I love to write `code` @ [GitHub](http://github.com)';
rocketship::string()->markdown($line);
```

----

### What If I Build MANY plugins — ALL powered by the WebSharks™ Core?

How does that work exactly? It's pretty simple really. You bundle the WebSharks™ Core with each plugin that you want to distribute. At runtime, the first plugin to introduce an instance of the WebSharks™ Core — wins! All of the other plugins that depend on the WebSharks™ Core will share that single instance.

This works out BEAUTIFULLY. It reduces the amount of code that is required to run each plugin. If all plugins were based on the WebSharks™ Core, you could potentially have hundreds of plugins running simultaneouly on a website; and most of these would include only small bits of code that add onto WordPress® (and the WebSharks™ Core) in different ways. All of them sharing a single instance of the WebSharks™ Core as their plugin framework of choice :-)