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
		 * @property actions                 $actions
		 * @property actions                 $action
		 * @method static actions actions()
		 * @method static actions action()
		 *
		 * @property arrays                  $arrays
		 * @property arrays                  $array
		 * @method static arrays arrays()
		 * @method static arrays array()
		 * @method static arrays ©array()
		 *
		 * @property booleans                $booleans
		 * @property booleans                $boolean
		 * @method static booleans booleans()
		 * @method static booleans boolean()
		 *
		 * @method static builder builder()
		 * @method static builder build()
		 *
		 * @property caps                    $caps
		 * @property caps                    $cap
		 * @method static caps caps()
		 * @method static caps cap()
		 *
		 * @property captchas                $captchas
		 * @property captchas                $captcha
		 * @method static captchas captchas()
		 * @method static captchas captcha()
		 *
		 * @property classes                 $classes
		 * @property classes                 $class
		 * @method static classes classes()
		 * @method static classes class()
		 * @method static classes ©class()
		 *
		 * @property commands                $commands
		 * @property commands                $command
		 * @method static commands commands()
		 * @method static commands command()
		 *
		 * @property compressor              $compressor
		 * @method static compressor compressor()
		 *
		 * @property cookies                 $cookies
		 * @property cookies                 $cookie
		 * @method static cookies cookies()
		 * @method static cookies cookie()
		 *
		 * @property css_minifier            $css_minifier
		 * @method static css_minifier css_minifier()
		 *
		 * @property crons                   $crons
		 * @property crons                   $cron
		 * @method static crons crons()
		 * @method static crons cron()
		 *
		 * @property currencies              $currencies
		 * @property currencies              $currency
		 * @method static currencies currencies()
		 * @method static currencies currency()
		 *
		 * @property dates                   $dates
		 * @property dates                   $date
		 * @method static dates dates()
		 * @method static dates date()
		 *
		 * @property \wpdb|db                $db
		 * @method static \wpdb|db db()
		 *
		 * @property db_cache                $db_cache
		 * @method static db_cache db_cache()
		 *
		 * @property db_tables               $db_tables
		 * @property db_tables               $db_table
		 * @method static db_tables db_tables()
		 * @method static db_tables db_table()
		 *
		 * @property db_utils                $db_utils
		 * @property db_utils                $db_util
		 * @method static db_utils db_utils()
		 * @method static db_utils db_util()
		 *
		 * @property diagnostics             $diagnostics
		 * @property diagnostics             $diagnostic
		 * @method static diagnostics diagnostics()
		 * @method static diagnostics diagnostic()
		 *
		 * @property dirs                    $dirs
		 * @property dirs                    $dir
		 * @method static dirs dirs()
		 * @method static dirs dir()
		 *
		 * @property encryption              $encryption
		 * @method static encryption encryption()
		 *
		 * @property env                     $env
		 * @method static env env()
		 *
		 * @property errors                  $errors
		 * @property errors                  $error
		 * @method static errors errors()
		 * @method static errors error()
		 *
		 * @property exception               $exception
		 * @method static exception exception()
		 *
		 * @property feeds                   $feeds
		 * @property feeds                   $feed
		 * @method static feeds feeds()
		 * @method static feeds feed()
		 *
		 * @property files                   $files
		 * @property files                   $file
		 * @method static files files()
		 * @method static files file()
		 *
		 * @property floats                  $floats
		 * @property floats                  $float
		 * @method static floats floats()
		 * @method static floats float()
		 *
		 * @property forms                   $forms
		 * @property forms                   $form
		 * @method static forms forms()
		 * @method static forms form()
		 *
		 * @property form_fields             $form_fields
		 * @property form_fields             $form_field
		 * @method static form_fields form_fields()
		 * @method static form_fields form_field()
		 *
		 * @property functions               $functions
		 * @property functions               $function
		 * @method static functions functions()
		 * @method static functions function()
		 * @method static functions ©function()
		 *
		 * @property headers                 $headers
		 * @property headers                 $header
		 * @method static headers headers()
		 * @method static headers header()
		 *
		 * @property html_minifier           $html_minifier
		 * @method static html_minifier html_minifier()
		 *
		 * @property initializer             $initializer
		 * @method static initializer initializer()
		 *
		 * @property installer               $installer
		 * @method static installer installer()
		 *
		 * @property integers                $integers
		 * @property integers                $integer
		 * @method static integers integers()
		 * @method static integers integer()
		 *
		 * @property ips                     $ips
		 * @property ips                     $ip
		 * @method static ips ips()
		 * @method static ips ip()
		 *
		 * @property js_minifier             $js_minifier
		 * @method static js_minifier js_minifier()
		 *
		 * @property mail                    $mail
		 * @method static mail mail()
		 *
		 * @property markdown                $markdown
		 * @method static markdown markdown()
		 *
		 * @property menu_pages              $menu_pages
		 * @property menu_pages              $menu_page
		 * @method static menu_pages menu_pages()
		 * @method static menu_pages menu_page()
		 *
		 * @property menu_pages\menu_page    $menu_pages__menu_page
		 * @method static menu_pages\menu_page menu_pages__menu_page()
		 *
		 * @property menu_pages\panels\panel $menu_pages__panels__panel
		 * @method static menu_pages\panels\panel menu_pages__panels__panel()
		 *
		 * @property messages                $messages
		 * @property messages                $message
		 * @method static messages messages()
		 * @method static messages message()
		 *
		 * @property functions               $methods
		 * @property functions               $method
		 * @method static functions methods()
		 * @method static functions method()
		 *
		 * @property no_cache                $no_cache
		 * @method static no_cache no_cache()
		 *
		 * @property notices                 $notices
		 * @property notices                 $notice
		 * @method static notices notices()
		 * @method static notices notice()
		 *
		 * @property oauth                   $oauth
		 * @method static oauth oauth()
		 *
		 * @property options                 $options
		 * @property options                 $option
		 * @method static options options()
		 * @method static options option()
		 *
		 * @property objects_os              $objects_os
		 * @property objects_os              $object_os
		 * @method static objects_os objects_os()
		 * @method static objects_os object_os()
		 *
		 * @property objects                 $objects
		 * @property objects                 $object
		 * @method static objects objects()
		 * @method static objects object()
		 *
		 * @property php                     $php
		 * @method static php php()
		 *
		 * @property plugins                 $plugins
		 * @property plugins                 $plugin
		 * @method static plugins plugins()
		 * @method static plugins plugin()
		 *
		 * @property posts                   $posts
		 * @property posts                   $post
		 * @method static posts posts()
		 * @method static posts post()
		 *
		 * @method static replicator replicator()
		 * @method static replicator replicate()
		 *
		 * @property scripts                 $scripts
		 * @property scripts                 $script
		 * @method static scripts scripts()
		 * @method static scripts script()
		 *
		 * @property strings                 $strings
		 * @property strings                 $string
		 * @method static strings strings()
		 * @method static strings string()
		 *
		 * @property styles                  $styles
		 * @property styles                  $style
		 * @method static styles styles()
		 * @method static styles style()
		 *
		 * @property successes               $successes
		 * @property successes               $success
		 * @method static successes successes()
		 * @method static successes success()
		 *
		 * @property templates               $templates
		 * @property templates               $template
		 * @method static templates templates()
		 * @method static templates template()
		 *
		 * @property urls                    $urls
		 * @property urls                    $url
		 * @method static urls urls()
		 * @method static urls url()
		 *
		 * @property vars                    $vars
		 * @property vars                    $var
		 * @method static vars vars()
		 * @method static vars var()
		 * @method static vars ©var()
		 *
		 * @property videos                  $videos
		 * @property videos                  $video
		 * @method static videos videos()
		 * @method static videos video()
		 *
		 * @property users                   $users
		 * @property users                   $user
		 * @method static users users()
		 * @method static users user()
		 *
		 * @property user_utils              $user_utils
		 * @method static user_utils user_utils()
		 *
		 * @property xml                     $xml
		 * @method static xml xml()
		 *
		 * @property object                  $___instance_config Public/magic read-only access.
		 */
		abstract class api implements fw_constants
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