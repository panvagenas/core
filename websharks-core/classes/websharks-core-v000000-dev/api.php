<?php
/**
 * Base API Class Abstraction.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */
namespace websharks_core_v000000_dev
	{
		if(!defined('WPINC'))
			exit('Do NOT access this file directly: '.basename(__FILE__));

		/**
		 * Base API Class Abstraction.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @note Dynamic properties/methods are defined explicitly here.
		 *    This way IDEs jive with ``__get()``, ``__call()`` and ``__callStatic()``.
		 *
		 * @note Some static calls to aliases without a `©` prefix will NOT work properly.
		 *    This occurs with dynamic WebSharks™ Core classes that use PHP keywords.
		 *    Such as: `::array`, `::class`, `::function` and `::var`.
		 *    For these static aliases one MUST use a `©` prefix.
		 *
		 * @property \websharks_core_v000000_dev\actions                 $actions
		 * @property \websharks_core_v000000_dev\actions                 $action
		 * @method static \websharks_core_v000000_dev\actions actions()
		 * @method static \websharks_core_v000000_dev\actions action()
		 *
		 * @property \websharks_core_v000000_dev\arrays                  $arrays
		 * @property \websharks_core_v000000_dev\arrays                  $array
		 * @method static \websharks_core_v000000_dev\arrays arrays()
		 * @method static \websharks_core_v000000_dev\arrays array()
		 * @method static \websharks_core_v000000_dev\arrays ©array()
		 *
		 * @property \websharks_core_v000000_dev\booleans                $booleans
		 * @property \websharks_core_v000000_dev\booleans                $boolean
		 * @method static \websharks_core_v000000_dev\booleans booleans()
		 * @method static \websharks_core_v000000_dev\booleans boolean()
		 *
		 * @method static \websharks_core_v000000_dev\builder builder()
		 * @method static \websharks_core_v000000_dev\builder build()
		 *
		 * @property \websharks_core_v000000_dev\caps                    $caps
		 * @property \websharks_core_v000000_dev\caps                    $cap
		 * @method static \websharks_core_v000000_dev\caps caps()
		 * @method static \websharks_core_v000000_dev\caps cap()
		 *
		 * @property \websharks_core_v000000_dev\captchas                $captchas
		 * @property \websharks_core_v000000_dev\captchas                $captcha
		 * @method static \websharks_core_v000000_dev\captchas captchas()
		 * @method static \websharks_core_v000000_dev\captchas captcha()
		 *
		 * @property \websharks_core_v000000_dev\classes                 $classes
		 * @property \websharks_core_v000000_dev\classes                 $class
		 * @method static \websharks_core_v000000_dev\classes classes()
		 * @method static \websharks_core_v000000_dev\classes class()
		 * @method static \websharks_core_v000000_dev\classes ©class()
		 *
		 * @property \websharks_core_v000000_dev\commands                $commands
		 * @property \websharks_core_v000000_dev\commands                $command
		 * @method static \websharks_core_v000000_dev\commands commands()
		 * @method static \websharks_core_v000000_dev\commands command()
		 *
		 * @property \websharks_core_v000000_dev\compressor              $compressor
		 * @method static \websharks_core_v000000_dev\compressor compressor()
		 *
		 * @property \websharks_core_v000000_dev\cookies                 $cookies
		 * @property \websharks_core_v000000_dev\cookies                 $cookie
		 * @method static \websharks_core_v000000_dev\cookies cookies()
		 * @method static \websharks_core_v000000_dev\cookies cookie()
		 *
		 * @property \websharks_core_v000000_dev\css_minifier            $css_minifier
		 * @method static \websharks_core_v000000_dev\css_minifier css_minifier()
		 *
		 * @property \websharks_core_v000000_dev\crons                   $crons
		 * @property \websharks_core_v000000_dev\crons                   $cron
		 * @method static \websharks_core_v000000_dev\crons crons()
		 * @method static \websharks_core_v000000_dev\crons cron()
		 *
		 * @property \websharks_core_v000000_dev\currencies              $currencies
		 * @property \websharks_core_v000000_dev\currencies              $currency
		 * @method static \websharks_core_v000000_dev\currencies currencies()
		 * @method static \websharks_core_v000000_dev\currencies currency()
		 *
		 * @property \websharks_core_v000000_dev\dates                   $dates
		 * @property \websharks_core_v000000_dev\dates                   $date
		 * @method static \websharks_core_v000000_dev\dates dates()
		 * @method static \websharks_core_v000000_dev\dates date()
		 *
		 * @property \wpdb|\websharks_core_v000000_dev\db                $db
		 * @method static \wpdb|\websharks_core_v000000_dev\db db()
		 *
		 * @property \websharks_core_v000000_dev\db_cache                $db_cache
		 * @method static \websharks_core_v000000_dev\db_cache db_cache()
		 *
		 * @property \websharks_core_v000000_dev\db_tables               $db_tables
		 * @property \websharks_core_v000000_dev\db_tables               $db_table
		 * @method static \websharks_core_v000000_dev\db_tables db_tables()
		 * @method static \websharks_core_v000000_dev\db_tables db_table()
		 *
		 * @property \websharks_core_v000000_dev\db_utils                $db_utils
		 * @property \websharks_core_v000000_dev\db_utils                $db_util
		 * @method static \websharks_core_v000000_dev\db_utils db_utils()
		 * @method static \websharks_core_v000000_dev\db_utils db_util()
		 *
		 * @property \websharks_core_v000000_dev\diagnostics             $diagnostics
		 * @property \websharks_core_v000000_dev\diagnostics             $diagnostic
		 * @method static \websharks_core_v000000_dev\diagnostics diagnostics()
		 * @method static \websharks_core_v000000_dev\diagnostics diagnostic()
		 *
		 * @property \websharks_core_v000000_dev\dirs                    $dirs
		 * @property \websharks_core_v000000_dev\dirs                    $dir
		 * @method static \websharks_core_v000000_dev\dirs dirs()
		 * @method static \websharks_core_v000000_dev\dirs dir()
		 *
		 * @property \websharks_core_v000000_dev\encryption              $encryption
		 * @method static \websharks_core_v000000_dev\encryption encryption()
		 *
		 * @property \websharks_core_v000000_dev\env                     $env
		 * @method static \websharks_core_v000000_dev\env env()
		 *
		 * @property \websharks_core_v000000_dev\errors                  $errors
		 * @property \websharks_core_v000000_dev\errors                  $error
		 * @method static \websharks_core_v000000_dev\errors errors()
		 * @method static \websharks_core_v000000_dev\errors error()
		 *
		 * @property \websharks_core_v000000_dev\exception               $exception
		 * @method static \websharks_core_v000000_dev\exception exception()
		 *
		 * @property \websharks_core_v000000_dev\feeds                   $feeds
		 * @property \websharks_core_v000000_dev\feeds                   $feed
		 * @method static \websharks_core_v000000_dev\feeds feeds()
		 * @method static \websharks_core_v000000_dev\feeds feed()
		 *
		 * @property \websharks_core_v000000_dev\files                   $files
		 * @property \websharks_core_v000000_dev\files                   $file
		 * @method static \websharks_core_v000000_dev\files files()
		 * @method static \websharks_core_v000000_dev\files file()
		 *
		 * @property \websharks_core_v000000_dev\floats                  $floats
		 * @property \websharks_core_v000000_dev\floats                  $float
		 * @method static \websharks_core_v000000_dev\floats floats()
		 * @method static \websharks_core_v000000_dev\floats float()
		 *
		 * @property \websharks_core_v000000_dev\forms                   $forms
		 * @property \websharks_core_v000000_dev\forms                   $form
		 * @method static \websharks_core_v000000_dev\forms forms()
		 * @method static \websharks_core_v000000_dev\forms form()
		 *
		 * @property \websharks_core_v000000_dev\form_fields             $form_fields
		 * @property \websharks_core_v000000_dev\form_fields             $form_field
		 * @method static \websharks_core_v000000_dev\form_fields form_fields()
		 * @method static \websharks_core_v000000_dev\form_fields form_field()
		 *
		 * @property \websharks_core_v000000_dev\functions               $functions
		 * @property \websharks_core_v000000_dev\functions               $function
		 * @method static \websharks_core_v000000_dev\functions functions()
		 * @method static \websharks_core_v000000_dev\functions function()
		 * @method static \websharks_core_v000000_dev\functions ©function()
		 *
		 * @property \websharks_core_v000000_dev\headers                 $headers
		 * @property \websharks_core_v000000_dev\headers                 $header
		 * @method static \websharks_core_v000000_dev\headers headers()
		 * @method static \websharks_core_v000000_dev\headers header()
		 *
		 * @property \websharks_core_v000000_dev\html_minifier           $html_minifier
		 * @method static \websharks_core_v000000_dev\html_minifier html_minifier()
		 *
		 * @property \websharks_core_v000000_dev\initializer             $initializer
		 * @method static \websharks_core_v000000_dev\initializer initializer()
		 *
		 * @property \websharks_core_v000000_dev\installer               $installer
		 * @method static \websharks_core_v000000_dev\installer installer()
		 *
		 * @property \websharks_core_v000000_dev\integers                $integers
		 * @property \websharks_core_v000000_dev\integers                $integer
		 * @method static \websharks_core_v000000_dev\integers integers()
		 * @method static \websharks_core_v000000_dev\integers integer()
		 *
		 * @property \websharks_core_v000000_dev\ips                     $ips
		 * @property \websharks_core_v000000_dev\ips                     $ip
		 * @method static \websharks_core_v000000_dev\ips ips()
		 * @method static \websharks_core_v000000_dev\ips ip()
		 *
		 * @property \websharks_core_v000000_dev\js_minifier             $js_minifier
		 * @method static \websharks_core_v000000_dev\js_minifier js_minifier()
		 *
		 * @property \websharks_core_v000000_dev\mail                    $mail
		 * @method static \websharks_core_v000000_dev\mail mail()
		 *
		 * @property \websharks_core_v000000_dev\markdown                $markdown
		 * @method static \websharks_core_v000000_dev\markdown markdown()
		 *
		 * @property \websharks_core_v000000_dev\menu_pages              $menu_pages
		 * @property \websharks_core_v000000_dev\menu_pages              $menu_page
		 * @method static \websharks_core_v000000_dev\menu_pages menu_pages()
		 * @method static \websharks_core_v000000_dev\menu_pages menu_page()
		 *
		 * @property \websharks_core_v000000_dev\menu_pages\menu_page    $menu_pages__menu_page
		 * @method static \websharks_core_v000000_dev\menu_pages\menu_page menu_pages__menu_page()
		 *
		 * @property \websharks_core_v000000_dev\menu_pages\panels\panel $menu_pages__panels__panel
		 * @method static \websharks_core_v000000_dev\menu_pages\panels\panel menu_pages__panels__panel()
		 *
		 * @property \websharks_core_v000000_dev\messages                $messages
		 * @property \websharks_core_v000000_dev\messages                $message
		 * @method static \websharks_core_v000000_dev\messages messages()
		 * @method static \websharks_core_v000000_dev\messages message()
		 *
		 * @property \websharks_core_v000000_dev\functions               $methods
		 * @property \websharks_core_v000000_dev\functions               $method
		 * @method static \websharks_core_v000000_dev\functions methods()
		 * @method static \websharks_core_v000000_dev\functions method()
		 *
		 * @property \websharks_core_v000000_dev\no_cache                $no_cache
		 * @method static \websharks_core_v000000_dev\no_cache no_cache()
		 *
		 * @property \websharks_core_v000000_dev\notices                 $notices
		 * @property \websharks_core_v000000_dev\notices                 $notice
		 * @method static \websharks_core_v000000_dev\notices notices()
		 * @method static \websharks_core_v000000_dev\notices notice()
		 *
		 * @property \websharks_core_v000000_dev\oauth                   $oauth
		 * @method static \websharks_core_v000000_dev\oauth oauth()
		 *
		 * @property \websharks_core_v000000_dev\options                 $options
		 * @property \websharks_core_v000000_dev\options                 $option
		 * @method static \websharks_core_v000000_dev\options options()
		 * @method static \websharks_core_v000000_dev\options option()
		 *
		 * @property \websharks_core_v000000_dev\objects_os              $objects_os
		 * @property \websharks_core_v000000_dev\objects_os              $object_os
		 * @method static \websharks_core_v000000_dev\objects_os objects_os()
		 * @method static \websharks_core_v000000_dev\objects_os object_os()
		 *
		 * @property \websharks_core_v000000_dev\objects                 $objects
		 * @property \websharks_core_v000000_dev\objects                 $object
		 * @method static \websharks_core_v000000_dev\objects objects()
		 * @method static \websharks_core_v000000_dev\objects object()
		 *
		 * @property \websharks_core_v000000_dev\php                     $php
		 * @method static \websharks_core_v000000_dev\php php()
		 *
		 * @property \websharks_core_v000000_dev\plugins                 $plugins
		 * @property \websharks_core_v000000_dev\plugins                 $plugin
		 * @method static \websharks_core_v000000_dev\plugins plugins()
		 * @method static \websharks_core_v000000_dev\plugins plugin()
		 *
		 * @property \websharks_core_v000000_dev\posts                   $posts
		 * @property \websharks_core_v000000_dev\posts                   $post
		 * @method static \websharks_core_v000000_dev\posts posts()
		 * @method static \websharks_core_v000000_dev\posts post()
		 *
		 * @method static \websharks_core_v000000_dev\replicator replicator()
		 * @method static \websharks_core_v000000_dev\replicator replicate()
		 *
		 * @property \websharks_core_v000000_dev\scripts                 $scripts
		 * @property \websharks_core_v000000_dev\scripts                 $script
		 * @method static \websharks_core_v000000_dev\scripts scripts()
		 * @method static \websharks_core_v000000_dev\scripts script()
		 *
		 * @property \websharks_core_v000000_dev\strings                 $strings
		 * @property \websharks_core_v000000_dev\strings                 $string
		 * @method static \websharks_core_v000000_dev\strings strings()
		 * @method static \websharks_core_v000000_dev\strings string()
		 *
		 * @property \websharks_core_v000000_dev\styles                  $styles
		 * @property \websharks_core_v000000_dev\styles                  $style
		 * @method static \websharks_core_v000000_dev\styles styles()
		 * @method static \websharks_core_v000000_dev\styles style()
		 *
		 * @property \websharks_core_v000000_dev\successes               $successes
		 * @property \websharks_core_v000000_dev\successes               $success
		 * @method static \websharks_core_v000000_dev\successes successes()
		 * @method static \websharks_core_v000000_dev\successes success()
		 *
		 * @property \websharks_core_v000000_dev\templates               $templates
		 * @property \websharks_core_v000000_dev\templates               $template
		 * @method static \websharks_core_v000000_dev\templates templates()
		 * @method static \websharks_core_v000000_dev\templates template()
		 *
		 * @property \websharks_core_v000000_dev\urls                    $urls
		 * @property \websharks_core_v000000_dev\urls                    $url
		 * @method static \websharks_core_v000000_dev\urls urls()
		 * @method static \websharks_core_v000000_dev\urls url()
		 *
		 * @property \websharks_core_v000000_dev\vars                    $vars
		 * @property \websharks_core_v000000_dev\vars                    $var
		 * @method static \websharks_core_v000000_dev\vars vars()
		 * @method static \websharks_core_v000000_dev\vars var()
		 * @method static \websharks_core_v000000_dev\vars ©var()
		 *
		 * @property \websharks_core_v000000_dev\videos                  $videos
		 * @property \websharks_core_v000000_dev\videos                  $video
		 * @method static \websharks_core_v000000_dev\videos videos()
		 * @method static \websharks_core_v000000_dev\videos video()
		 *
		 * @property \websharks_core_v000000_dev\users                   $users
		 * @property \websharks_core_v000000_dev\users                   $user
		 * @method static \websharks_core_v000000_dev\users users()
		 * @method static \websharks_core_v000000_dev\users user()
		 *
		 * @property \websharks_core_v000000_dev\user_utils              $user_utils
		 * @method static \websharks_core_v000000_dev\user_utils user_utils()
		 *
		 * @property \websharks_core_v000000_dev\xml                     $xml
		 * @method static \websharks_core_v000000_dev\xml xml()
		 *
		 * @property object                                              $___instance_config Public/magic read-only access.
		 */
		abstract class api // Stand-alone class.
		{
			/**
			 * Framework for current plugin instance.
			 *
			 * @var framework Framework for current plugin instance.
			 *
			 * @by-constructor Set by class constructor (if API class is instantiated).
			 *
			 * @final Should NOT be overridden by class extenders.
			 *    Would be `final` if PHP allowed such a thing.
			 *
			 * @protected Available only to self & extenders.
			 */
			protected $framework; // NULL value (by default).

			/**
			 * Constructs global framework reference.
			 *
			 * @constructor Sets up global framework reference.
			 *
			 * @throws exception If unable to locate current plugin framework instance.
			 *
			 * @final Cannot be overridden by class extenders.
			 *
			 * @public A magic/overload constructor MUST always remain public.
			 */
			final public function __construct()
				{
					$class = get_class($this); // Class name.

					if($class === ($core_ns = core()->___instance_config->core_ns).'\\core')
						{
							if(!isset($GLOBALS[$core_ns]) || !($GLOBALS[$core_ns] instanceof framework))
								throw core()->©exception(
									__METHOD__.'#missing_framework_instance', get_defined_vars(),
									sprintf(core()->i18n('Missing $GLOBALS[\'%1$s\'] framework instance.'), $core_ns)
								);
							$this->framework = $GLOBALS[$core_ns];
							return; // Stop (special case; we're all done).
						}
					if(!isset($GLOBALS[$class]->___instance_config->{core()->___instance_config->core_ns_stub}))
						throw core()->©exception(
							__METHOD__.'#missing_framework_instance', get_defined_vars(),
							sprintf(core()->i18n('Missing $GLOBALS[\'%1$s\'] framework instance.'), $class)
						);
					$this->framework = $GLOBALS[$class];
				}

			/**
			 * Handles overload properties (dynamic classes).
			 *
			 * @param string $dyn_class A dynamic class object name
			 *    (w/o the `©` prefix) — simplifying usage (if you prefer).
			 *
			 * @return framework|object A singleton class instance.
			 *
			 * @final Cannot be overridden by class extenders.
			 *
			 * @public Magic/overload methods are always public.
			 */
			final public function __get($dyn_class)
				{
					return $this->framework->{'©'.ltrim($dyn_class, '©')};
				}

			/**
			 * Handles overload methods (dynamic classes).
			 *
			 * @param string $dyn_class A dynamic class object name
			 *    (w/o the `©` prefix) — simplifying usage (if you prefer).
			 *
			 * @param array  $args Optional. Any arguments that should be
			 *    passed into the dynamic class constructor.
			 *
			 * @return framework|object A new dynamic class instance.
			 *
			 * @final Cannot be overridden by class extenders.
			 *
			 * @public Magic/overload methods are always public.
			 */
			final public function __call($dyn_class, $args = array())
				{
					return call_user_func_array(array($this->framework, '©'.ltrim($dyn_class, '©')), $args);
				}

			/**
			 * Framework for current plugin instance.
			 *
			 * @return framework Framework for current plugin instance.
			 *
			 * @throws exception If unable to locate current plugin framework instance.
			 *
			 * @final Cannot be overridden by class extenders.
			 *
			 * @public Available for public access.
			 */
			final public static function framework()
				{
					static $framework; // A static cache.
					// For each class that extends this abstraction.

					if(isset($framework)) return $framework; // Cached?

					$class = get_called_class(); // With late static binding.

					if($class === ($core_ns = core()->___instance_config->core_ns).'\\core')
						{
							if(!isset($GLOBALS[$core_ns]) || !($GLOBALS[$core_ns] instanceof framework))
								throw core()->©exception(
									__METHOD__.'#missing_framework_instance', get_defined_vars(),
									sprintf(core()->i18n('Missing $GLOBALS[\'%1$s\'] framework instance.'), $core_ns)
								);
							return ($framework = $GLOBALS[$core_ns]); // Stop (special case; we're all done).
						}
					if(!isset($GLOBALS[$class]->___instance_config->{core()->___instance_config->core_ns_stub}))
						throw core()->©exception(
							__METHOD__.'#missing_framework_instance', get_defined_vars(),
							sprintf(core()->i18n('Missing $GLOBALS[\'%1$s\'] framework instance.'), $class)
						);
					return ($framework = $GLOBALS[$class]);
				}

			/**
			 * Handles static overload methods (dynamic classes).
			 *
			 * @param string $dyn_class A dynamic class object name
			 *    (w/o the `©` prefix) — simplifying usage (if you prefer).
			 *
			 * @param array  $args Optional. If arguments are passed through,
			 *    a new dynamic class instance will be instantiated.
			 *
			 * @return framework|object A singleton class object instance.
			 *    (or a new dynamic class instance; if there are arguments).
			 *
			 * @final Cannot be overridden by class extenders.
			 *
			 * @public Magic methods are always public.
			 */
			final public static function __callStatic($dyn_class, $args = array())
				{
					if(!empty($args)) // Instantiate a new class instance w/ arguments.
						return call_user_func_array(array(static::framework(), '©'.ltrim($dyn_class, '©')), $args);

					return static::framework()->{'©'.ltrim($dyn_class, '©')};
				}
		}
	}