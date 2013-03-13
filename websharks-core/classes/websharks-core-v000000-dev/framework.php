<?php
/**
 * WebSharks™ Core Framework.
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

		if(!class_exists('\\'.__NAMESPACE__.'\\framework'))
			{
				if(!class_exists('\\'.__NAMESPACE__))
					include_once dirname(dirname(dirname(__FILE__))).'/stub.php';

				if(!class_exists('\\deps_'.__NAMESPACE__.''))
					include_once dirname(__FILE__).'/deps.php';
				/**
				 * WebSharks™ Core Framework.
				 *
				 * @package WebSharks\Core
				 * @since 120318
				 *
				 * @assert ($GLOBALS[__NAMESPACE__])
				 *
				 * @note Dynamic properties/methods are defined explicitly here.
				 *    This way IDEs jive with ``__get()`` and ``__call()``.
				 *
				 * @property \websharks_core_v000000_dev\actions                 $©actions
				 * @property \websharks_core_v000000_dev\actions                 $©action
				 * @method \websharks_core_v000000_dev\actions ©actions()
				 * @method \websharks_core_v000000_dev\actions ©action()
				 *
				 * @property \websharks_core_v000000_dev\arrays                  $©arrays
				 * @property \websharks_core_v000000_dev\arrays                  $©array
				 * @method \websharks_core_v000000_dev\arrays ©arrays()
				 * @method \websharks_core_v000000_dev\arrays ©array()
				 *
				 * @property \websharks_core_v000000_dev\booleans                $©booleans
				 * @property \websharks_core_v000000_dev\booleans                $©boolean
				 * @method \websharks_core_v000000_dev\booleans ©booleans()
				 * @method \websharks_core_v000000_dev\booleans ©boolean()
				 *
				 * @method \websharks_core_v000000_dev\builder ©builder()
				 * @method \websharks_core_v000000_dev\builder ©build()
				 *
				 * @property \websharks_core_v000000_dev\caps                    $©caps
				 * @property \websharks_core_v000000_dev\caps                    $©cap
				 * @method \websharks_core_v000000_dev\caps ©caps()
				 * @method \websharks_core_v000000_dev\caps ©cap()
				 *
				 * @property \websharks_core_v000000_dev\captchas                $©captchas
				 * @property \websharks_core_v000000_dev\captchas                $©captcha
				 * @method \websharks_core_v000000_dev\captchas ©captchas()
				 * @method \websharks_core_v000000_dev\captchas ©captcha()
				 *
				 * @property \websharks_core_v000000_dev\classes                 $©classes
				 * @property \websharks_core_v000000_dev\classes                 $©class
				 * @method \websharks_core_v000000_dev\classes ©classes()
				 * @method \websharks_core_v000000_dev\classes ©class()
				 *
				 * @property \websharks_core_v000000_dev\commands                $©commands
				 * @property \websharks_core_v000000_dev\commands                $©command
				 * @method \websharks_core_v000000_dev\commands ©commands()
				 * @method \websharks_core_v000000_dev\commands ©command()
				 *
				 * @property \websharks_core_v000000_dev\compressor              $©compressor
				 * @method \websharks_core_v000000_dev\compressor ©compressor()
				 *
				 * @property \websharks_core_v000000_dev\cookies                 $©cookies
				 * @property \websharks_core_v000000_dev\cookies                 $©cookie
				 * @method \websharks_core_v000000_dev\cookies ©cookies()
				 * @method \websharks_core_v000000_dev\cookies ©cookie()
				 *
				 * @property \websharks_core_v000000_dev\css_minifier            $©css_minifier
				 * @method \websharks_core_v000000_dev\css_minifier ©css_minifier()
				 *
				 * @property \websharks_core_v000000_dev\crons                   $©crons
				 * @property \websharks_core_v000000_dev\crons                   $©cron
				 * @method \websharks_core_v000000_dev\crons ©crons()
				 * @method \websharks_core_v000000_dev\crons ©cron()
				 *
				 * @property \websharks_core_v000000_dev\currencies              $©currencies
				 * @property \websharks_core_v000000_dev\currencies              $©currency
				 * @method \websharks_core_v000000_dev\currencies ©currencies()
				 * @method \websharks_core_v000000_dev\currencies ©currency()
				 *
				 * @property \websharks_core_v000000_dev\dates                   $©dates
				 * @property \websharks_core_v000000_dev\dates                   $©date
				 * @method \websharks_core_v000000_dev\dates ©dates()
				 * @method \websharks_core_v000000_dev\dates ©date()
				 *
				 * @property \wpdb|\websharks_core_v000000_dev\db                $©db
				 * @method \wpdb|\websharks_core_v000000_dev\db ©db()
				 *
				 * @property \websharks_core_v000000_dev\db_cache                $©db_cache
				 * @method \websharks_core_v000000_dev\db_cache ©db_cache()
				 *
				 * @property \websharks_core_v000000_dev\db_tables               $©db_tables
				 * @property \websharks_core_v000000_dev\db_tables               $©db_table
				 * @method \websharks_core_v000000_dev\db_tables ©db_tables()
				 * @method \websharks_core_v000000_dev\db_tables ©db_table()
				 *
				 * @property \websharks_core_v000000_dev\db_utils                $©db_utils
				 * @property \websharks_core_v000000_dev\db_utils                $©db_util
				 * @method \websharks_core_v000000_dev\db_utils ©db_utils()
				 * @method \websharks_core_v000000_dev\db_utils ©db_util()
				 *
				 * @property \websharks_core_v000000_dev\diagnostics             $©diagnostics
				 * @property \websharks_core_v000000_dev\diagnostics             $©diagnostic
				 * @method \websharks_core_v000000_dev\diagnostics ©diagnostics()
				 * @method \websharks_core_v000000_dev\diagnostics ©diagnostic()
				 *
				 * @property \websharks_core_v000000_dev\dirs                    $©dirs
				 * @property \websharks_core_v000000_dev\dirs                    $©dir
				 * @method \websharks_core_v000000_dev\dirs ©dirs()
				 * @method \websharks_core_v000000_dev\dirs ©dir()
				 *
				 * @property \websharks_core_v000000_dev\encryption              $©encryption
				 * @method \websharks_core_v000000_dev\encryption ©encryption()
				 *
				 * @property \websharks_core_v000000_dev\env                     $©env
				 * @method \websharks_core_v000000_dev\env ©env()
				 *
				 * @property \websharks_core_v000000_dev\errors                  $©errors
				 * @property \websharks_core_v000000_dev\errors                  $©error
				 * @method \websharks_core_v000000_dev\errors ©errors()
				 * @method \websharks_core_v000000_dev\errors ©error()
				 *
				 * @property \websharks_core_v000000_dev\exception               $©exception
				 * @method \websharks_core_v000000_dev\exception ©exception()
				 *
				 * @property \websharks_core_v000000_dev\feeds                   $©feeds
				 * @property \websharks_core_v000000_dev\feeds                   $©feed
				 * @method \websharks_core_v000000_dev\feeds ©feeds()
				 * @method \websharks_core_v000000_dev\feeds ©feed()
				 *
				 * @property \websharks_core_v000000_dev\files                   $©files
				 * @property \websharks_core_v000000_dev\files                   $©file
				 * @method \websharks_core_v000000_dev\files ©files()
				 * @method \websharks_core_v000000_dev\files ©file()
				 *
				 * @property \websharks_core_v000000_dev\floats                  $©floats
				 * @property \websharks_core_v000000_dev\floats                  $©float
				 * @method \websharks_core_v000000_dev\floats ©floats()
				 * @method \websharks_core_v000000_dev\floats ©float()
				 *
				 * @property \websharks_core_v000000_dev\forms                   $©forms
				 * @property \websharks_core_v000000_dev\forms                   $©form
				 * @method \websharks_core_v000000_dev\forms ©forms()
				 * @method \websharks_core_v000000_dev\forms ©form()
				 *
				 * @property \websharks_core_v000000_dev\form_fields             $©form_fields
				 * @property \websharks_core_v000000_dev\form_fields             $©form_field
				 * @method \websharks_core_v000000_dev\form_fields ©form_fields()
				 * @method \websharks_core_v000000_dev\form_fields ©form_field()
				 *
				 * @property \websharks_core_v000000_dev\functions               $©functions
				 * @property \websharks_core_v000000_dev\functions               $©function
				 * @method \websharks_core_v000000_dev\functions ©functions()
				 * @method \websharks_core_v000000_dev\functions ©function()
				 *
				 * @property \websharks_core_v000000_dev\headers                 $©headers
				 * @property \websharks_core_v000000_dev\headers                 $©header
				 * @method \websharks_core_v000000_dev\headers ©headers()
				 * @method \websharks_core_v000000_dev\headers ©header()
				 *
				 * @property \websharks_core_v000000_dev\html_minifier           $©html_minifier
				 * @method \websharks_core_v000000_dev\html_minifier ©html_minifier()
				 *
				 * @property \websharks_core_v000000_dev\initializer             $©initializer
				 * @method \websharks_core_v000000_dev\initializer ©initializer()
				 *
				 * @property \websharks_core_v000000_dev\installer               $©installer
				 * @method \websharks_core_v000000_dev\installer ©installer()
				 *
				 * @property \websharks_core_v000000_dev\integers                $©integers
				 * @property \websharks_core_v000000_dev\integers                $©integer
				 * @method \websharks_core_v000000_dev\integers ©integers()
				 * @method \websharks_core_v000000_dev\integers ©integer()
				 *
				 * @property \websharks_core_v000000_dev\ips                     $©ips
				 * @property \websharks_core_v000000_dev\ips                     $©ip
				 * @method \websharks_core_v000000_dev\ips ©ips()
				 * @method \websharks_core_v000000_dev\ips ©ip()
				 *
				 * @property \websharks_core_v000000_dev\js_minifier             $©js_minifier
				 * @method \websharks_core_v000000_dev\js_minifier ©js_minifier()
				 *
				 * @property \websharks_core_v000000_dev\mail                    $©mail
				 * @method \websharks_core_v000000_dev\mail ©mail()
				 *
				 * @property \websharks_core_v000000_dev\markdown                $©markdown
				 * @method \websharks_core_v000000_dev\markdown ©markdown()
				 *
				 * @property \websharks_core_v000000_dev\menu_pages              $©menu_pages
				 * @property \websharks_core_v000000_dev\menu_pages              $©menu_page
				 * @method \websharks_core_v000000_dev\menu_pages ©menu_pages()
				 * @method \websharks_core_v000000_dev\menu_pages ©menu_page()
				 *
				 * @property \websharks_core_v000000_dev\menu_pages\menu_page    $©menu_pages__menu_page
				 * @method \websharks_core_v000000_dev\menu_pages\menu_page ©menu_pages__menu_page()
				 *
				 * @property \websharks_core_v000000_dev\menu_pages\panels\panel $©menu_pages__panels__panel
				 * @method \websharks_core_v000000_dev\menu_pages\panels\panel ©menu_pages__panels__panel()
				 *
				 * @property \websharks_core_v000000_dev\messages                $©messages
				 * @property \websharks_core_v000000_dev\messages                $©message
				 * @method \websharks_core_v000000_dev\messages ©messages()
				 * @method \websharks_core_v000000_dev\messages ©message()
				 *
				 * @property \websharks_core_v000000_dev\functions               $©methods
				 * @property \websharks_core_v000000_dev\functions               $©method
				 * @method \websharks_core_v000000_dev\functions ©methods()
				 * @method \websharks_core_v000000_dev\functions ©method()
				 *
				 * @property \websharks_core_v000000_dev\no_cache                $©no_cache
				 * @method \websharks_core_v000000_dev\no_cache ©no_cache()
				 *
				 * @property \websharks_core_v000000_dev\notices                 $©notices
				 * @property \websharks_core_v000000_dev\notices                 $©notice
				 * @method \websharks_core_v000000_dev\notices ©notices()
				 * @method \websharks_core_v000000_dev\notices ©notice()
				 *
				 * @property \websharks_core_v000000_dev\oauth                   $©oauth
				 * @method \websharks_core_v000000_dev\oauth ©oauth()
				 *
				 * @property \websharks_core_v000000_dev\options                 $©options
				 * @property \websharks_core_v000000_dev\options                 $©option
				 * @method \websharks_core_v000000_dev\options ©options()
				 * @method \websharks_core_v000000_dev\options ©option()
				 *
				 * @property \websharks_core_v000000_dev\objects_os              $©objects_os
				 * @property \websharks_core_v000000_dev\objects_os              $©object_os
				 * @method \websharks_core_v000000_dev\objects_os ©objects_os()
				 * @method \websharks_core_v000000_dev\objects_os ©object_os()
				 *
				 * @property \websharks_core_v000000_dev\objects                 $©objects
				 * @property \websharks_core_v000000_dev\objects                 $©object
				 * @method \websharks_core_v000000_dev\objects ©objects()
				 * @method \websharks_core_v000000_dev\objects ©object()
				 *
				 * @property \websharks_core_v000000_dev\php                     $©php
				 * @method \websharks_core_v000000_dev\php ©php()
				 *
				 * @property \websharks_core_v000000_dev\plugins                 $©plugins
				 * @property \websharks_core_v000000_dev\plugins                 $©plugin
				 * @method \websharks_core_v000000_dev\plugins ©plugins()
				 * @method \websharks_core_v000000_dev\plugins ©plugin()
				 *
				 * @property \websharks_core_v000000_dev\posts                   $©posts
				 * @property \websharks_core_v000000_dev\posts                   $©post
				 * @method \websharks_core_v000000_dev\posts ©posts()
				 * @method \websharks_core_v000000_dev\posts ©post()
				 *
				 * @method \websharks_core_v000000_dev\replicator ©replicator()
				 * @method \websharks_core_v000000_dev\replicator ©replicate()
				 *
				 * @property \websharks_core_v000000_dev\scripts                 $©scripts
				 * @property \websharks_core_v000000_dev\scripts                 $©script
				 * @method \websharks_core_v000000_dev\scripts ©scripts()
				 * @method \websharks_core_v000000_dev\scripts ©script()
				 *
				 * @property \websharks_core_v000000_dev\strings                 $©strings
				 * @property \websharks_core_v000000_dev\strings                 $©string
				 * @method \websharks_core_v000000_dev\strings ©strings()
				 * @method \websharks_core_v000000_dev\strings ©string()
				 *
				 * @property \websharks_core_v000000_dev\styles                  $©styles
				 * @property \websharks_core_v000000_dev\styles                  $©style
				 * @method \websharks_core_v000000_dev\styles ©styles()
				 * @method \websharks_core_v000000_dev\styles ©style()
				 *
				 * @property \websharks_core_v000000_dev\successes               $©successes
				 * @property \websharks_core_v000000_dev\successes               $©success
				 * @method \websharks_core_v000000_dev\successes ©successes()
				 * @method \websharks_core_v000000_dev\successes ©success()
				 *
				 * @property \websharks_core_v000000_dev\templates               $©templates
				 * @property \websharks_core_v000000_dev\templates               $©template
				 * @method \websharks_core_v000000_dev\templates ©templates()
				 * @method \websharks_core_v000000_dev\templates ©template()
				 *
				 * @property \websharks_core_v000000_dev\urls                    $©urls
				 * @property \websharks_core_v000000_dev\urls                    $©url
				 * @method \websharks_core_v000000_dev\urls ©urls()
				 * @method \websharks_core_v000000_dev\urls ©url()
				 *
				 * @property \websharks_core_v000000_dev\vars                    $©vars
				 * @property \websharks_core_v000000_dev\vars                    $©var
				 * @method \websharks_core_v000000_dev\vars ©vars()
				 * @method \websharks_core_v000000_dev\vars ©var()
				 *
				 * @property \websharks_core_v000000_dev\videos                  $©videos
				 * @property \websharks_core_v000000_dev\videos                  $©video
				 * @method \websharks_core_v000000_dev\videos ©videos()
				 * @method \websharks_core_v000000_dev\videos ©video()
				 *
				 * @property \websharks_core_v000000_dev\users                   $©users
				 * @property \websharks_core_v000000_dev\users                   $©user
				 * @method \websharks_core_v000000_dev\users ©users()
				 * @method \websharks_core_v000000_dev\users ©user()
				 *
				 * @property \websharks_core_v000000_dev\user_utils              $©user_utils
				 * @method \websharks_core_v000000_dev\user_utils ©user_utils()
				 *
				 * @property \websharks_core_v000000_dev\xml                     $©xml
				 * @method \websharks_core_v000000_dev\xml ©xml()
				 */
				class framework // WebSharks™ Core Framework.
				{
					/**
					 * Current instance object.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var object Current instance object for ``$this``.
					 *    Defaults to NULL. Set by constructor.
					 *
					 * @by-constructor Set by class constructor.
					 */
					public $___instance_config;

					/**
					 * A global/static cache of all instance configurations.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array A global/static cache of all instance configurations.
					 *    Defaults to an empty array. Set by constructor.
					 *
					 * @by-constructor Set by class constructor.
					 */
					public static $___instance_config_cache = array();

					/**
					 * A global/static cache for dynamic singleton object references.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array A global/static cache for dynamic singleton object references.
					 *    Defaults to an empty array. Set by ``__get()`` method.
					 *
					 * @see The ``__get()`` method for further details on this.
					 */
					public static $___dynamic_class_reference_cache = array();

					/**
					 * A global/static cache for dynamic singleton object instances.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array A global/static cache for dynamic singleton object instances.
					 *    Defaults to an empty array. Set by ``__get()`` method.
					 *
					 * @see The ``__get()`` method for further details on this.
					 */
					public static $___dynamic_class_instance_cache = array();

					/**
					 * Dynamic class aliases.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @extenders Class aliases should NOT be overridden. Use ``$___instance_config`` instead please.
					 *    Class extenders can add their own dynamic class aliases into an ``$___instance_config``.
					 *
					 * @see The ``__get()`` and ``__call()`` methods, for further details on this.
					 *
					 * @var array Associative array of dynamic class aliases.
					 */
					public static $___dynamic_class_aliases = array(
						'action'     => 'actions',
						'array'      => 'arrays',
						'boolean'    => 'booleans',
						'build'      => 'builder',
						'cap'        => 'caps',
						'captcha'    => 'captchas',
						'class'      => 'classes',
						'command'    => 'commands',
						'cookie'     => 'cookies',
						'cron'       => 'crons',
						'currency'   => 'currencies',
						'date'       => 'dates',
						'db_table'   => 'db_tables',
						'db_util'    => 'db_utils',
						'diagnostic' => 'diagnostics',
						'dir'        => 'dirs',
						'error'      => 'errors',
						'feed'       => 'feeds',
						'file'       => 'files',
						'float'      => 'floats',
						'form'       => 'forms',
						'form_field' => 'form_fields',
						'function'   => 'functions',
						'menu_page'  => 'menu_pages',
						'message'    => 'messages',
						'methods'    => 'functions',
						'method'     => 'functions',
						'header'     => 'headers',
						'integer'    => 'integers',
						'ip'         => 'ips',
						'notice'     => 'notices',
						'option'     => 'options',
						'object_os'  => 'objects_os',
						'object'     => 'objects',
						'plugin'     => 'plugins',
						'post'       => 'posts',
						'replicate'  => 'replicator',
						'script'     => 'scripts',
						'string'     => 'strings',
						'style'      => 'styles',
						'success'    => 'successes',
						'template'   => 'templates',
						'url'        => 'urls',
						'user'       => 'users',
						'var'        => 'vars',
						'video'      => 'videos'
					);

					/**
					 * PHP's ``is_...()`` type checks.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array PHP ``is_...()`` type checks.
					 *    Keys correspond with type hints accepted by ``check_arg_types()``.
					 *    Values are ``is_...()`` functions needed to test for each type.
					 */
					public static $___is_type_checks = array(
						'string'          => 'is_string',
						'!string'         => 'is_string',
						'string:!empty'   => 'is_string',

						'boolean'         => 'is_bool',
						'!boolean'        => 'is_bool',
						'boolean:!empty'  => 'is_bool',

						'bool'            => 'is_bool',
						'!bool'           => 'is_bool',
						'bool:!empty'     => 'is_bool',

						'integer'         => 'is_integer',
						'!integer'        => 'is_integer',
						'integer:!empty'  => 'is_integer',

						'int'             => 'is_integer',
						'!int'            => 'is_integer',
						'int:!empty'      => 'is_integer',

						'float'           => 'is_float',
						'!float'          => 'is_float',
						'float:!empty'    => 'is_float',

						'real'            => 'is_float',
						'!real'           => 'is_float',
						'real:!empty'     => 'is_float',

						'double'          => 'is_float',
						'!double'         => 'is_float',
						'double:!empty'   => 'is_float',

						'numeric'         => 'is_numeric',
						'!numeric'        => 'is_numeric',
						'numeric:!empty'  => 'is_numeric',

						'scalar'          => 'is_scalar',
						'!scalar'         => 'is_scalar',
						'scalar:!empty'   => 'is_scalar',

						'array'           => 'is_array',
						'!array'          => 'is_array',
						'array:!empty'    => 'is_array',

						'object'          => 'is_object',
						'!object'         => 'is_object',
						'object:!empty'   => 'is_object',

						'resource'        => 'is_resource',
						'!resource'       => 'is_resource',
						'resource:!empty' => 'is_resource',

						'null'            => 'is_null',
						'!null'           => 'is_null',
						'null:!empty'     => 'is_null'
					);

					/**
					 * A global/static cache for each class extender.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array A global/static cache for each class extender.
					 *    Defaults to an empty array. Set by ``___static()`` method.
					 *
					 * @see The ``___static()`` method for further details on this.
					 */
					public static $___statics = array();

					/**
					 * Gets/sets static cache values on a per-class basis.
					 *
					 * @final May NOT be overridden by extenders.
					 *
					 * @param string|integer $key Key to get/set.
					 * @param mixed          $value If passed, we set (or update) the value for ``$key``.
					 *
					 * @return mixed A reference to the value for ``$key``.
					 *    If no arguments are passed; a reference to the entire cache array.
					 *
					 * @throws \exception If ``$key`` is passed; and it's NOT a string|integer.
					 */
					final public static function &___static($key = NULL, $value = NULL)
						{
							$func_num_args = func_num_args();
							$class         = get_called_class();

							if(!isset(static::$___statics[$class]))
								static::$___statics[$class] = array();

							if(!$func_num_args) // Entire array?
								return static::$___statics[$class];

							if((!is_string($key) && !is_integer($key)) || !strlen($key))
								throw new \exception(
									_x('Invalid `$key` to `static::cache()` method in core.',
									   'websharks-core--admin-side core-cache', 'websharks-core')
								);
							if(!isset(static::$___statics[$class][$key]))
								static::$___statics[$class][$key] = NULL;

							if($func_num_args >= 2) // Setting this key?
								static::$___statics[$class][$key] = $value;

							return static::$___statics[$class][$key];
						}

					/**
					 * An instance-based reference to the global/static cache for each class.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array An instance-based reference to the global/static cache for each class.
					 *    Defaults to an empty array.
					 *
					 * @by-constructor Set by class constructor.
					 */
					public $static = array();

					/**
					 * An instance-based cache for each class.
					 *
					 * @final Should NOT be overridden by class extenders.
					 *    Would be `final` if PHP allowed such a thing.
					 *
					 * @var array An instance-based cache for each class.
					 *    Defaults to an empty array.
					 */
					public $cache = array();

					// WebSharks™ Core class constants.

					/**
					 * Represents the WebSharks™ Core.
					 *
					 * @var string Used by some class methods.
					 */
					const core = '___core';

					/**
					 * Represents `object` properties.
					 *
					 * @var string Used by some class methods.
					 */
					const object_p = '___object_p';

					/**
					 * Represents associative `array`.
					 *
					 * @var string Used by some class methods.
					 */
					const array_a = '___array_a';

					/**
					 * Represents numeric `array`.
					 *
					 * @var string Used by some class methods.
					 */
					const array_n = '___array_n';

					/**
					 * Represents space-separated `string`.
					 *
					 * @var string Used by some class methods.
					 */
					const space_sep_string = '___space_sep_string';

					/**
					 * Represents `all` logic.
					 *
					 * @var string Used by some class methods.
					 */
					const all_logic = '___all_logic';

					/**
					 * Represents `any` logic.
					 *
					 * @var string Used by some class methods.
					 */
					const any_logic = '___any_logic';

					/**
					 * Represents a reconsideration.
					 *
					 * @var string Used by some class methods.
					 */
					const reconsider = '___reconsider';

					/**
					 * Represents logging enabled.
					 *
					 * @var string Used by some class methods.
					 */
					const log_enable = '___log_enable';

					/**
					 * Represents logging disabled.
					 *
					 * @var string Used by some class methods.
					 */
					const log_disable = '___log_disable';

					/**
					 * Represents a `public` type.
					 *
					 * @var string Used by some class methods.
					 */
					const public_type = '___public_type';

					/**
					 * Represents a `protected` type.
					 *
					 * @var string Used by some class methods.
					 */
					const protected_type = '___protected_type';

					/**
					 * Represents a `private` type.
					 *
					 * @var string Used by some class methods.
					 */
					const private_type = '___private_type';

					/**
					 * Represents conformity with rfc1738.
					 *
					 * @var string Used by some class methods.
					 * @see http://www.faqs.org/rfcs/rfc1738.html
					 */
					const rfc1738 = '___rfc1738';

					/**
					 * Represents conformity with rfc3986.
					 *
					 * @var string Used by some class methods.
					 * @see http://www.faqs.org/rfcs/rfc3986
					 */
					const rfc3986 = '___rfc3986';

					/**
					 * Represents own components.
					 *
					 * @var string Used by some class methods.
					 */
					const own_components = '___own_components';

					/**
					 * Represents do `echo` command.
					 *
					 * @var string Used by some class methods.
					 */
					const do_echo = '___do_echo';

					/**
					 * Represents a direct call, as opposed to a hook/filter.
					 *
					 * @var string Used by some class methods.
					 */
					const direct_call = '___direct_call';

					/**
					 * Represents ``preg_replace()`` type.
					 *
					 * @var string Used by some class methods.
					 */
					const preg_replace_type = '___preg_replace_type';

					/**
					 * Represents ``str_replace()`` type.
					 *
					 * @var string Used by some class methods.
					 */
					const str_replace_type = '___str_replace_type';

					/**
					 * Represents PHP regex flavor.
					 *
					 * @var string Used by some class methods.
					 */
					const regex_php = '___regex_php';

					/**
					 * Represents JavaScript regex flavor.
					 *
					 * @var string Used by some class methods.
					 */
					const regex_js = '___regex_js';

					/**
					 * Represents `profile_updates` context.
					 *
					 * @var string Used by some class methods.
					 */
					const context_registration = '___context_registration';

					/**
					 * Represents `profile_updates` context.
					 *
					 * @var string Used by some class methods.
					 */
					const context_profile_updates = '___context_profile_updates';

					/**
					 * Represents `profile_updates` context.
					 *
					 * @var string Used by some class methods.
					 */
					const context_profile_views = '___context_profile_views';

					/**
					 * Core class constructor.
					 *
					 * @param object|array $___instance_config Required at all times.
					 *    A parent object instance, which contains the parent's ``$___instance_config``,
					 *    or a new ``$___instance_config`` array.
					 *
					 *    An array MUST contain the following elements:
					 *       • ``(string)$___instance_config['plugin_name']`` — Name of current plugin.
					 *       • ``(string)$___instance_config['plugin_var_ns']`` — Plugin variable namespace.
					 *       • ``(string)$___instance_config['plugin_root_ns']`` — Root namespace of current plugin.
					 *       • ``(string)$___instance_config['plugin_version']`` — Version of current plugin.
					 *       • ``(string)$___instance_config['plugin_dir']`` — Current plugin directory.
					 *       • ``(string)$___instance_config['plugin_site']`` — Plugin site URL (http://).
					 *       • ``(array)$___instance_config['dynamic_class_aliases']`` — Class aliases.
					 *
					 * @throws \exception If there is a missing and/or invalid ``$___instance_config``.
					 * @throws \exception If more than 7 configuration elements exist in an ``$__instance_config`` array.
					 *
					 * @throws \exception If the plugin's variable namespace does NOT match this regex pattern validation.
					 *    See: {@link \websharks_core_v000000_dev\strings::$_4fwc_regex_valid_ws_plugin_var_ns}
					 *
					 * @throws \exception If the plugin's root namespace does NOT match this regex pattern validation.
					 *    See: {@link \websharks_core_v000000_dev\strings::$_4fwc_regex_valid_ws_plugin_root_ns}
					 *
					 * @throws \exception If the plugin's version does NOT match this regex pattern validation.
					 *    See: {@link websharks_core_v000000_dev\strings::$_4fwc_regex_valid_ws_version}
					 *
					 * @throws \exception If the plugin's directory is missing (e.g. the plugin's directory MUST actually exist).
					 *    In addition, the plugin's directory MUST contain a main plugin file with the name `plugin.php`.
					 *
					 * @throws \exception If the plugin's site URL, is NOT valid (MUST start with `http://.+`).
					 *
					 * @throws \exception If the array of dynamic class aliases is NOT an array (it can be empty though).
					 *
					 * @throws \exception If the namespace\class path does NOT match this regex pattern validation.
					 *    See: {@link \websharks_core_v000000_dev\strings::$_4fwc_regex_valid_ws_ns_class}
					 *
					 * @throws \exception If the core namespace does NOT match this regex pattern validation.
					 *    See: {@link \websharks_core_v000000_dev\strings::$_4fwc_regex_valid_ws_core_ns_version}
					 *
					 * @extenders CAN be overridden by class extenders.
					 *
					 *    • Regarding a standard in the WebSharks™ Core...
					 *       If a class extender creates its own ``__construct()`` method it MUST collect an ``$___instance_config``,
					 *       and it MUST call upon this core constructor using: ``parent::__construct($___instance_config)``.
					 *
					 * @note This method should NOT rely directly or indirectly on any other core class objects.
					 *    HOWEVER: It is OK for this constructor to call upon static properties (like regex patterns).
					 *    Or anything designed specifically for the framework constructor (i.e. it includes this prefix: `_4fwc`).
					 */
					public function __construct($___instance_config)
						{
							// Instance-based reference to global/static cache.
							$this->static =& static::___static();

							// Have a parent object instance?
							if($___instance_config instanceof framework)
								$___parent_instance_config = $___instance_config->___instance_config;
							else $___parent_instance_config = NULL;

							// If we got a parent instance config, check the cache BEFORE we clone (saves processing).
							if(isset($___parent_instance_config)) // In any case, we can bypass validation here.
								{
									$cache_entry = $___parent_instance_config->plugin_root_ns.($ns_class = get_class($this));

									if(isset(static::$___instance_config_cache[$cache_entry]))
										{
											$this->___instance_config = static::$___instance_config_cache[$cache_entry];
											return; // Using cache. Nothing more to do here.
										}
									$this->___instance_config           = clone $___parent_instance_config;
									$this->___instance_config->ns_class = $ns_class; // `namespace\sub_namespace\class_name`.
								}

							// Else, this MUST be a valid array (else throw exception).
							else if(is_array($___instance_config) && count($___instance_config) === 7

							        && !empty($___instance_config['plugin_name']) && is_string($___instance_config['plugin_name'])

							        && !empty($___instance_config['plugin_var_ns']) && is_string($___instance_config['plugin_var_ns'])
							        && preg_match(strings::$_4fwc_regex_valid_ws_plugin_var_ns, $___instance_config['plugin_var_ns'])

							        && !empty($___instance_config['plugin_root_ns']) && is_string($___instance_config['plugin_root_ns'])
							        && preg_match(strings::$_4fwc_regex_valid_ws_plugin_root_ns, $___instance_config['plugin_root_ns'])

							        && !empty($___instance_config['plugin_version']) && is_string($___instance_config['plugin_version'])
							        && preg_match(strings::$_4fwc_regex_valid_ws_version, $___instance_config['plugin_version'])

							        && !empty($___instance_config['plugin_dir']) && is_string($___instance_config['plugin_dir'])
							        && is_dir($___instance_config['plugin_dir'] = dirs::_4fwc_n_seps($___instance_config['plugin_dir']))
							        && is_file($___instance_config['plugin_dir'].'/plugin.php')

							        && !empty($___instance_config['plugin_site']) && is_string($___instance_config['plugin_site'])
							        && preg_match('/^http\:\/\/.+/i', $___instance_config['plugin_site'])

							        && isset($___instance_config['dynamic_class_aliases']) && is_array($___instance_config['dynamic_class_aliases'])

							) // A fully validated ``$___instance_config`` array (we'll convert to an object now).
								{
									$this->___instance_config           = (object)$___instance_config;
									$cache_entry                        = $this->___instance_config->plugin_root_ns.($ns_class = get_class($this));
									$this->___instance_config->ns_class = $ns_class; // `namespace\sub_namespace\class_name`.

									if(isset(static::$___instance_config_cache[$cache_entry]))
										{
											$this->___instance_config = static::$___instance_config_cache[$cache_entry];
											return; // Using cache (nothing more to do here).
										}
								}
							else throw new \exception(
								sprintf(_x('Invalid `$___instance_config` to core constructor: `%1$s`',
								           'websharks-core--admin-side core-constructor', 'websharks-core'),
								        print_r($___instance_config, TRUE))
							);

							// Based on `namespace\sub_namespace\class_name` for ``$this`` class.
							$this->___instance_config->ns_class_prefix           = '\\'.$this->___instance_config->ns_class;
							$this->___instance_config->ns_class_with_underscores = str_replace('\\', '__', $this->___instance_config->ns_class);
							$this->___instance_config->ns_class_with_dashes      = str_replace('_', '-', $this->___instance_config->ns_class_with_underscores);
							$this->___instance_config->ns_class_basename         = basename(str_replace('\\', '/', $this->___instance_config->ns_class));

							// Check `namespace\sub_namespace\class_name` for validation issues.
							if(!preg_match(strings::$_4fwc_regex_valid_ws_ns_class, $this->___instance_config->ns_class))
								throw new \exception(
									sprintf(_x('Namespace\\class contains invalid chars: `%1$s`.',
									           'websharks-core--admin-side core-constructor', 'websharks-core'),
									        $this->___instance_config->ns_class)
								);

							// Based on this core ``__NAMESPACE__``. These properties will NOT change from one class instance to another.
							if(!$___parent_instance_config) // Therefore, we ONLY need this routine if we did NOT get a ``$___parent_instance``.
								{
									// Based on this core ``__NAMESPACE__`` (as defined in this file).
									$this->___instance_config->core_ns             = __NAMESPACE__;
									$this->___instance_config->core_ns_prefix      = '\\'.$this->___instance_config->core_ns;
									$this->___instance_config->core_ns_with_dashes = str_replace('_', '-', $this->___instance_config->core_ns);

									$this->___instance_config->core_ns_stub             = 'websharks_core';
									$this->___instance_config->core_ns_stub_with_dashes = 'websharks-core';

									$this->___instance_config->core_ns_v             = substr($this->___instance_config->core_ns, strlen($this->___instance_config->core_ns_stub) + 2);
									$this->___instance_config->core_ns_v_with_dashes = str_replace('_', '-', $this->___instance_config->core_ns_v);
									$this->___instance_config->core_version          =& $this->___instance_config->core_ns_v_with_dashes;

									// Check core ``__NAMESPACE__`` for validation issues.
									if(!preg_match(strings::$_4fwc_regex_valid_ws_core_ns_version, $this->___instance_config->core_ns))
										throw new \exception(
											sprintf(_x('Core namespace contains invalid chars: `%1$s`.',
											           'websharks-core--admin-side core-constructor', 'websharks-core'),
											        $this->___instance_config->core_ns)
										);
								}

							// The `namespace\sub_namespace` for ``$this`` class.
							$this->___instance_config->ns = (string)substr($this->___instance_config->ns_class, 0, strrpos($this->___instance_config->ns_class, '\\'));

							// Only if we're NOT in the same namespace as the ``$___parent_instance``.
							if(!$___parent_instance_config || $___parent_instance_config->ns !== $this->___instance_config->ns)
								{
									// Based on `namespace\sub_namespace` for ``$this`` class.
									$this->___instance_config->ns_prefix           = '\\'.$this->___instance_config->ns;
									$this->___instance_config->ns_with_underscores = str_replace('\\', '__', $this->___instance_config->ns);
									$this->___instance_config->ns_with_dashes      = str_replace('_', '-', $this->___instance_config->ns_with_underscores);

									// Based on `namespace` for ``$this`` class.
									$this->___instance_config->root_ns             = strstr($this->___instance_config->ns_class, '\\', TRUE);
									$this->___instance_config->root_ns_prefix      = '\\'.$this->___instance_config->root_ns;
									$this->___instance_config->root_ns_with_dashes = str_replace('_', '-', $this->___instance_config->root_ns);
								}

							// Based on the current plugin. These properties will NOT change from one class instance to another.
							if(!$___parent_instance_config) // ONLY need this routine if we did NOT get a ``$___parent_instance``.
								{
									// Based on `plugin_var_ns` (which serves several purposes).
									$this->___instance_config->plugin_prefix  = $this->___instance_config->plugin_var_ns.'_';
									$this->___instance_config->plugin_api_var = $this->___instance_config->plugin_var_ns;

									// Based on plugin's root `namespace` (via `plugin_root_ns`).
									$this->___instance_config->plugin_root_ns_prefix      = '\\'.$this->___instance_config->plugin_root_ns;
									$this->___instance_config->plugin_root_ns_with_dashes = str_replace('_', '-', $this->___instance_config->plugin_root_ns);

									// Based on plugin's root `namespace` (via `plugin_root_ns`).
									// Here we check to see if this plugin is actually the WebSharks™ Core.
									// In this case we need to use the WebSharks™ Core stub instead of the plugin's root namespace.
									if($this->___instance_config->plugin_root_ns === $this->___instance_config->core_ns)
										{
											$this->___instance_config->plugin_root_ns_stub             = $this->___instance_config->core_ns_stub;
											$this->___instance_config->plugin_root_ns_stub_with_dashes = $this->___instance_config->core_ns_stub_with_dashes;
										}
									else // Otherwise, proceed normally. In this case, we're just making a copy of `plugin_root_ns` properties.
										{
											$this->___instance_config->plugin_root_ns_stub             = $this->___instance_config->plugin_root_ns;
											$this->___instance_config->plugin_root_ns_stub_with_dashes = $this->___instance_config->plugin_root_ns_with_dashes;
										}
									// Based on the plugin's directory (i.e. `plugin_dir`).
									$this->___instance_config->plugin_dir_basename      = basename($this->___instance_config->plugin_dir);
									$this->___instance_config->plugin_dir_file_basename = $this->___instance_config->plugin_dir_basename.'/plugin.php';
									$this->___instance_config->plugin_data_dir          = apply_filters($this->___instance_config->plugin_root_ns_stub.'__data_dir', $this->___instance_config->plugin_dir.'-data');
									$this->___instance_config->plugin_file              = $this->___instance_config->plugin_dir.'/plugin.php';
									$this->___instance_config->plugin_framework_file    = $this->___instance_config->plugin_dir.'/framework.php';
									$this->___instance_config->plugin_api_class_file    = $this->___instance_config->plugin_dir.'/classes/api.php';

									// Based on the current plugin, establish properties for a pro add-on.
									$this->___instance_config->plugin_pro_var               = $this->___instance_config->plugin_root_ns.'_pro';
									$this->___instance_config->plugin_pro_dir               = $this->___instance_config->plugin_dir.'-pro';
									$this->___instance_config->plugin_pro_dir_basename      = basename($this->___instance_config->plugin_pro_dir);
									$this->___instance_config->plugin_pro_dir_file_basename = $this->___instance_config->plugin_pro_dir_basename.'/plugin.php';
									$this->___instance_config->plugin_pro_file              = $this->___instance_config->plugin_pro_dir.'/plugin.php';
									$this->___instance_config->plugin_pro_class_file        = $this->___instance_config->plugin_pro_dir.'/pro.php';
								}
							// Based on `plugin_root_ns_stub`.
							// AND, also on `namespace\sub_namespace\class_name` for ``$this`` class.
							// Here we swap out the real root namespace, in favor of the plugin's root namespace.
							// This is helpful when we need to build strings for hooks, filters, contextual slugs, and the like.
							$root_ns_length                                                          = strlen($this->___instance_config->root_ns);
							$ns_class_x_same_as_class                                                = preg_replace('/_x$/', '', $this->___instance_config->ns_class);
							$this->___instance_config->plugin_stub_as_root_ns_class                  = $this->___instance_config->plugin_root_ns_stub.substr($ns_class_x_same_as_class, $root_ns_length);
							$this->___instance_config->plugin_stub_as_root_ns_class_with_underscores = str_replace('\\', '__', $this->___instance_config->plugin_stub_as_root_ns_class);
							$this->___instance_config->plugin_stub_as_root_ns_class_with_dashes      = str_replace('_', '-', $this->___instance_config->plugin_stub_as_root_ns_class_with_underscores);

							// Based on `plugin_root_ns_stub`.
							// AND, also on `namespace\sub_namespace` for ``$this`` class.
							// Here we swap out the real root namespace, in favor of the plugin's root namespace.
							// This is helpful when we need to build strings for hooks, filters, contextual slugs, and the like.
							$this->___instance_config->plugin_stub_as_root_ns                  = $this->___instance_config->plugin_root_ns_stub.substr($this->___instance_config->ns, $root_ns_length);
							$this->___instance_config->plugin_stub_as_root_ns_with_underscores = str_replace('\\', '__', $this->___instance_config->plugin_stub_as_root_ns);
							$this->___instance_config->plugin_stub_as_root_ns_with_dashes      = str_replace('_', '-', $this->___instance_config->plugin_stub_as_root_ns_with_underscores);

							// Now let's cache ``$this->___instance_config`` for easy re-use.
							static::$___instance_config_cache[$cache_entry] = $this->___instance_config;
						}

					/**
					 * Checks overload properties (and dynamic singleton class instances).
					 *
					 * @param string  $property Name of a valid overload property.
					 *    Or a dynamic class to check, using the special class `©` prefix.
					 *
					 * @return boolean TRUE if the overload property (or dynamic singleton class instance) is set.
					 *    Otherwise, this will return FALSE by default (i.e. the property is NOT set).
					 */
					public function __isset($property)
						{
							// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since the PHP interpreter usually calls this, it's pretty safe.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$property    = (string)$property; // Typecasting this to a string value.
							$blog_id     = (integer)$GLOBALS['blog_id']; // Typecasting as integer.
							$cache_entry = $this->___instance_config->plugin_root_ns.'#'.$property;

							return isset(static::$___dynamic_class_reference_cache[$blog_id][$cache_entry]);
						}

					/**
					 * Handles overload properties (and dynamic singleton class instances).
					 *
					 * @param string  $property Name of a valid overload property.
					 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
					 *
					 *    When a class `©` prefix is present, we look for the class to exist first in the current plugin's root namespace, else in the core namespace.
					 *    Do NOT create plugin classes with the same names as those in the core, unless you really want to override or extend the core version.
					 *
					 *    Note... this routine treats double underscores like namespace separators, so double underscores will prevent dynamic usage.
					 *    This point is actually moot, since the core constructor does NOT allow double underscores anyway.
					 *
					 *    The object that's returned, is a dynamic singleton for each plugin (to clarify, one single instance of each dynamic class, for each plugin).
					 *    This OOP design pattern can be more accurately described as a {@link http://en.wikipedia.org/wiki/Multiton_pattern Multiton}.
					 *    However, this takes even the concept of a Multiton a little further. For instance, the cache routine here is MUCH smarter.
					 *    Also, here we're overloading dynamic singleton classes with `©`, and also dealing with class aliases.
					 *
					 *    Repeat calls will return an existing instance, if one exists for the current plugin; else a new instance is instantiated here.
					 *    When/if a new instance is instantiated here, we pass the current object (i.e. ``$this``) to the constructor.
					 *    The resulting instance is then cached into memory, for the current plugin to re-use.
					 *
					 *    A quick example might look like: ``$this->©class``. Which becomes: ``new \plugin_root_ns\class()``.
					 *    If ``\plugin_root_ns\class()`` is missing, we'll try ``new \websharks_core_v000000_dev\class()``.
					 *
					 *    If a sub-namespace is needed, suffix the required sub-namespace(s) with double underscores `__`.
					 *    A quick example might look like: ``$this->©sub_namespace__sub_namespace__class``.
					 *    Which becomes: ``new \plugin_root_ns\sub_namespace\sub_namespace\class()``.
					 *    Or: ``new \websharks_core_v000000_dev\sub_namespace\sub_namespace\class()``.
					 *
					 *    If the property contains a fully qualified namespace, use a `©` suffix, instead of a prefix.
					 *    Then use double underscores `__` to separate any namespace paths in the property name.
					 *    A quick example: ``$this->my_namespace__sub_namespace__class©``.
					 *    Becomes: ``new \my_namespace\sub_namespace\class()``.
					 *
					 *    This method also takes dynamic class aliases into consideration.
					 *       See: ``$___dynamic_class_aliases`` for further details.
					 *       See: ``$___instance_config->dynamic_class_aliases`` for further details.
					 *
					 * @return mixed Dynamic property values, or a dynamic object instance; else an exception is thrown.
					 *    Dynamic class instances are defined explicitly in the docBlock above.
					 *    This way IDEs will jive with this dynamic behavior.
					 *
					 * @throws exception If ``$property`` CANNOT be defined in any way.
					 *
					 * @note It is intentionally NOT possible to pass additional arguments to an object constructor this way.
					 *    Any class that needs to be constructed with more than an ``$___instance_config``, cannot be instantiated here.
					 *    Instead see ``__call()`` to instantiate "new" dynamic object instances with `©`.
					 *
					 * @extenders CAN be overridden by class extenders.
					 *    Note... regarding a standard in the WebSharks™ Core.
					 *    If a class extender creates its own ``__get()`` method, it MUST first make an attempt to resolve ``$property`` on its own.
					 *    If it CANNOT resolve ``$property``, it MUST then return a call to this method, using: ``parent::__get($property)``.
					 *    This allows the core ``__get()`` method to make a final attempt at resolving the value of ``$property``.
					 *
					 * @note This method should NOT rely directly or indirectly on any other dynamic properties.
					 *    That would create a case of endless recursion.
					 *
					 * @assert ('©strings') instanceof '\\websharks_core_v000000_dev\\strings'
					 * @assert ('©string') instanceof '\\websharks_core_v000000_dev\\strings'
					 * @assert ('©method') instanceof '\\websharks_core_v000000_dev\\functions'
					 */
					public function __get($property)
						{
							// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since the PHP interpreter usually calls this, it's pretty safe.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$property    = (string)$property; // Typecasting this to a string value.
							$blog_id     = (integer)$GLOBALS['blog_id']; // Typecasting as integer.
							$cache_entry = $this->___instance_config->plugin_root_ns.'#'.$property;

							// Let's start by checking the cache (saves processing). NOTE: there's a separate cache for each blog ID.
							// See also: <http://codex.wordpress.org/WPMU_Functions/switch_to_blog> — in the WordPress® core.

							if(isset(static::$___dynamic_class_reference_cache[$blog_id][$cache_entry]) /* Cached already? */)
								return static::$___dynamic_class_reference_cache[$blog_id][$cache_entry];

							if(($©strpos = strpos($property, '©')) !== FALSE) // A dynamic singleton is being requested in this case.
								{
									// Note... this ``$dyn_class`` may or may not contain a fully qualified namespace. In some cases it will (if `©` is a suffix).
									// However, in most cases ``$dyn_class`` will contain only a class name itself, or perhaps a sub_namespace\class.
									$dyn_class = str_replace('__', '\\', trim($property, '©')); // Converts to a ``$dyn_class`` path.

									// This maps dynamic class aliases to their real (i.e. actual class) counterparts.
									// Mapped by ``$property``, after it's been converted into a ``$dyn_class`` path, and BEFORE any prefixes occur.
									// Example: ``$this->©sub_namespace__class`` maps to the alias entry `sub_namespace\class`.
									// Another example: ``$this->©class`` maps to the alias entry `class`.

									if(!empty($this->___instance_config->dynamic_class_aliases[$dyn_class]))
										$dyn_class = $this->___instance_config->dynamic_class_aliases[$dyn_class];

									else if(!empty(static::$___dynamic_class_aliases[$dyn_class]))
										$dyn_class = static::$___dynamic_class_aliases[$dyn_class];

									// Now let's establish an array of lookups.
									$dyn_class_lookups = array(); // Possible locations.

									if($©strpos !== 0) // Assuming a fully qualified namespace has been given in this case.
										$dyn_class_lookups[] = '\\'.$dyn_class; // So we only add the `\` prefix.

									else // Otherwise try ``$this->___instance_config->plugin_root_ns``, then ``$this->___instance_config->core_ns``.
										{
											$dyn_class_lookups[] = $this->___instance_config->plugin_root_ns_prefix.'\\'.$dyn_class;
											$dyn_class_lookups[] = $this->___instance_config->core_ns_prefix.'\\'.$dyn_class;
										}

									// Note... ``$cache`` entries are created for each ``$this->___instance_config->plugin_root_ns.$property`` combination.
									// However, ``$dyn_class_instances`` may contain entries used under several different aliases (i.e. by more than one cache entry).
									// Therefore, ALWAYS check for the existence of a class instance first, even if a cache entry for it is currently missing.
									// In other words, the instance itself may already exist; and perhaps we just need a new cache entry to reference it.

									foreach($dyn_class_lookups as $_dyn_class)
										{
											$_dyn_class_entry = $this->___instance_config->plugin_root_ns.'#'.$_dyn_class;

											if(isset(static::$___dynamic_class_instance_cache[$blog_id][$_dyn_class_entry]))
												{
													return (static::$___dynamic_class_reference_cache[$blog_id][$cache_entry]
														= static::$___dynamic_class_instance_cache[$blog_id][$_dyn_class_entry]);
												}
											else if(class_exists($_dyn_class)) // Triggers autoloader.
												{
													static::$___dynamic_class_instance_cache[$blog_id][$_dyn_class_entry] = new $_dyn_class($this);

													return (static::$___dynamic_class_reference_cache[$blog_id][$cache_entry]
														= static::$___dynamic_class_instance_cache[$blog_id][$_dyn_class_entry]);
												}
										}
									unset($_dyn_class, $_dyn_class_entry); // A little housekeeping.
								}
							throw new exception(
								$this, __METHOD__.'#undefined_property', array('args' => func_get_args()),
								sprintf($this->i18n('Undefined property: `%1$s`.'), $property)
							);
						}

					/**
					 * Handles overload methods (and dynamic class instances).
					 *
					 * @param string $method Name of a valid overload method to call upon.
					 *    Or a dynamic class to return an instance of, using the special class `©` prefix.
					 *    Or a dynamic singleton class method to call upon; also using the `©` prefix, along with a `.method_name` suffix.
					 *
					 *    When a class `©` prefix is present, we look for the class to exist first in the current plugin's root namespace, else in the core namespace.
					 *    Do NOT create plugin classes with the same names as those in the core, unless you really want to override or extend the core version.
					 *
					 *    Note... this routine treats double underscores like namespace separators, so double underscores will prevent dynamic usage.
					 *    This point is actually moot, since the core constructor does NOT allow double underscores anyway.
					 *
					 *    Repeat calls will NOT return an existing instance (exception: dynamic singleton methods). Otherwise, each call instantiates a new dynamic class instance.
					 *    This OOP design pattern can be more accurately described as a {@link http://en.wikipedia.org/wiki/Factory_method_pattern Factory}.
					 *    However, this takes even the concept of a Factory a little further. Here we're overloading dynamic factory classes with `©`,
					 *    and we're also dealing with dynamic class aliases.
					 *
					 *    A quick example might look like: ``$this->©class($arg1, $arg2)``. Which becomes: ``new \plugin_root_ns\class($arg1, $arg2)``.
					 *    If ``\plugin_root_ns\class()`` is missing, we'll try ``new \websharks_core_v000000_dev\class($arg1, $arg2)``.
					 *
					 *    If a sub-namespace is needed, suffix the required sub-namespace(s) with double underscores `__`.
					 *    A quick example might look like: ``$this->©sub_namespace__sub_namespace__class($arg1, $arg2)``.
					 *    Which becomes: ``new \plugin_root_ns\sub_namespace\sub_namespace\class($arg1, $arg2)``.
					 *    Or: ``new \websharks_core_v000000_dev\sub_namespace\sub_namespace\class($arg1, $arg2)``.
					 *
					 *    If the method name contains a fully qualified namespace, use a `©` suffix, instead of a prefix.
					 *    Then use double underscores `__` to separate any namespace paths in the property name.
					 *    A quick example: ``$this->my_namespace__sub_namespace__class©($arg1, $arg2)``.
					 *    Becomes: ``new \my_namespace\sub_namespace\class($arg1, $arg2)``.
					 *
					 *    As mentioned earlier, it is also possible to call a dynamic singleton class method; also using the `©` prefix, along with a `.method_name` suffix.
					 *    This special combination is handled a bit differently. We make a call to the ``__get()`` method in this case, for the dynamic singleton instance.
					 *    Then, we use the dynamic singleton instance, and issue a call to `.method_name`, with ``$args`` passing through as well.
					 *    A quick example: ``call_user_func_array(array($this, '©class.method_name'), array($arg1, $arg2))``.
					 *    Another example: ``add_action('init', array($this, '©class.method_name'))``.
					 *
					 *    This method also takes dynamic class aliases into consideration.
					 *       See: ``$___dynamic_class_aliases`` for further details.
					 *       See: ``$___instance_config->dynamic_class_aliases`` for further details.
					 *
					 * @param array  $args An array of arguments to the overload method, or dynamic class object constructor.
					 *    In the case of dynamic objects, it's fine to exclude the first argument, which is handled automatically by this routine.
					 *    That is, the first argument to any extender is always the parent instance (i.e. ``$this``).
					 *
					 * @return mixed Dynamic return values, or a dynamic object instance; else an exception is thrown.
					 *    Dynamic class instances are defined explicitly in the docBlock above.
					 *    This way IDEs will jive with this dynamic behavior.
					 *
					 * @throws exception If ``$method`` CANNOT be defined in any way.
					 *
					 * @extenders CAN be overridden by class extenders.
					 *    Note... regarding a standard in the WebSharks™ Core.
					 *    If a class extender creates its own ``__call()`` method, it MUST first make an attempt to resolve ``$method`` on its own.
					 *    If it CANNOT resolve ``$method``, it MUST then return a call to this method, using: ``parent::__call($method, $args)``.
					 *    This allows the core ``__call()`` method to make a final attempt at resolving the value of ``$method``.
					 *
					 * @note This method should NOT rely directly or indirectly on any other dynamic methods.
					 *    That would create a case of endless recursion.
					 *
					 * @assert ('©strings', array()) instanceof ('\\websharks_core_v000000_dev\\strings')
					 * @assert ('©string', array()) instanceof ('\\websharks_core_v000000_dev\\strings')
					 * @assert ('©method', array()) instanceof ('\\websharks_core_v000000_dev\\functions')
					 */
					public function __call($method, $args)
						{
							// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since the PHP interpreter usually calls this, it's pretty safe.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$method = (string)$method; // Typecasting this to a string value.
							$args   = (array)$args; // Typecast these arguments to an array value.

							// Handles dynamic/overload methods, using the special class `©` character.

							if(($©strpos = strpos($method, '©')) !== FALSE) // Looking for a dynamic class?
								{
									// If ``$method`` ends with a `.method_name` we handle things quite differently.
									if(strpos($method, '.') !== FALSE) // Calling a dynamic class method?
										{
											list($dyn_class, $dyn_method) = explode('.', $method, 2);
											return call_user_func_array(array($this->__get($dyn_class), $dyn_method), $args);
										}

									// Note... this ``$dyn_class`` may or may not contain a fully qualified namespace. In some cases it will (if `©` is a suffix).
									// However, in most cases ``$dyn_class`` will contain only a class name itself, or perhaps a sub_namespace\class.
									$dyn_class = str_replace('__', '\\', trim($method, '©')); // Converts to a ``$dyn_class`` path.

									// This maps dynamic class aliases to their real (i.e. actual class) counterparts.
									// Mapped by ``$method``, after it's been converted into a ``$dyn_class`` path, and BEFORE any prefixes occur.
									// Example: ``$this->©sub_namespace__class()`` maps to the alias entry `sub_namespace\class`.
									// Another example: ``$this->©class()`` maps to the alias entry `class`.

									if(!empty($this->___instance_config->dynamic_class_aliases[$dyn_class]))
										$dyn_class = $this->___instance_config->dynamic_class_aliases[$dyn_class];

									else if(!empty(static::$___dynamic_class_aliases[$dyn_class]))
										$dyn_class = static::$___dynamic_class_aliases[$dyn_class];

									// Now let's establish an array of lookups.
									$dyn_class_lookups = array(); // Possible locations.

									if($©strpos !== 0) // Assuming a fully qualified namespace has been given in this case.
										$dyn_class_lookups[] = '\\'.$dyn_class; // So we only add the `\` prefix.

									else // Otherwise try ``$this->___instance_config->plugin_root_ns``, then ``$this->___instance_config->core_ns``.
										{
											$dyn_class_lookups[] = $this->___instance_config->plugin_root_ns_prefix.'\\'.$dyn_class;
											$dyn_class_lookups[] = $this->___instance_config->core_ns_prefix.'\\'.$dyn_class;
										}

									// Regarding a standard in the WebSharks™ Core.
									// When/if a class extender creates its own ``__construct()`` method,
									// it MUST collect an ``$___instance_config``, and it MUST call: ``parent::__construct($___instance_config)``.

									// Now let's try to find the class.
									foreach($dyn_class_lookups as $_dyn_class)
										{
											if(class_exists($_dyn_class)) // Triggers autoloader.
												{
													switch(count($args)) // Handles up to 10 hard coded ``$args``.
													{
														// This tries to avoid the ReflectionClass, because it's MUCH slower.
														// If there's more than 10 arguments to a constructor, we'll have to use it though, unfortunately.
														// However, it's NOT likely. More than 10 arguments to a constructor is NOT a common practice.
														case 0:
																return new $_dyn_class($this);
														case 1:
																return new $_dyn_class($this, $args[0]);
														case 2:
																return new $_dyn_class($this, $args[0], $args[1]);
														case 3:
																return new $_dyn_class($this, $args[0], $args[1], $args[2]);
														case 4:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3]);
														case 5:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4]);
														case 6:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5]);
														case 7:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6]);
														case 8:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7]);
														case 9:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8]);
														case 10:
																return new $_dyn_class($this, $args[0], $args[1], $args[2], $args[3], $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]);
														default:
															$args                 = array_merge(array($this), $args);
															$_dyn_class_reflector = new \ReflectionClass($_dyn_class);
															return $_dyn_class_reflector->newInstanceArgs($args);
													}
												}
										}
									unset($_dyn_class, $_dyn_class_reflector);
								}
							throw new exception(
								$this, __METHOD__.'#undefined_method', array('args' => func_get_args()),
								sprintf($this->i18n('Undefined method: `%1$s`.'), $method)
							);
						}

					/**
					 * Checks function/method arguments against a list of type hints.
					 *
					 * @note Very important for this method to remain HIGHLY optimized at all times.
					 *    This method is called MANY times throughout the entire WebSharks™ Core framework.
					 *
					 * @FUTURE Further optimize this routine. It's about 6.5 times slower than ``is_...()`` checks alone (in PHP v5.3.13).
					 *    We've ALREADY put quite a bit of work into optimizing this as-is, so we might need an entirely new approach in the future.
					 *    Benchmarking this against straight `is..()` checks alone, is not really fair; since this routine "enforces" type hints.
					 *    In the mean time, the benefits of using this method, far outweigh the cost in performance — in most cases.
					 *    ~ Hopefully we'll have better support for type hinting upon the release of PHP 6.0.
					 *
					 * @dev-note Try NOT to ``check_arg_types()`` recursively (i.e. in recursive functions). It's really a waste of resources.
					 *    If a function is going to be called recursively, please design your function (while in recursion), to bypass ``check_arg_types()``.
					 *
					 * @final May NOT be overridden by extenders.
					 *
					 * @params-variable-length This method accepts any number of parameters (i.e. type hints, as seen below).
					 *
					 * @note Arguments to this method should first include a variable-length list of type hints.
					 *
					 *    Format as follows: ``check_arg_types('[type]', '[type]' ..., func_get_args())``.
					 *    Where type hint arguments MUST be ordered exactly the same as each argument requested by the function/method we're checking.
					 *    However, it's fine to exclude certain arguments from the end (i.e. any we don't need to check), or via exclusion w/ an empty string.
					 *
					 *    Where `[type]` can be any string (or array combination) of: `:!empty|int|integer|real|double|float|string|bool|boolean|array|object|resource|scalar|numeric|null|[instanceof]`.
					 *    Where `[instanceof]` can be used in cases where we need to check for a specific type of object instance. Anything not matching a standardized type, is assumed to be an `[instanceof]` check.
					 *    For performance reasons, `[type]` is caSe sensitive. Therefore, `INTeger` will NOT match `integer` (that would be invalid; resulting in a check requiring an instance of `INTeger`).
					 *
					 *    Negating certain types.
					 *    Example: ``check_arg_types('!object', func_get_args())``.
					 *    Allows anything, except an object type.
					 *
					 *    Require values that are NOT ``empty()``.
					 *    Example: ``check_arg_types('string:!empty', func_get_args())``.
					 *    Requires a string that is NOT considered ``empty()`` by the PHP interpreter.
					 *
					 *    Require anything that is NOT ``empty()``.
					 *    Example: ``check_arg_types(':!empty', func_get_args())``.
					 *    Anything that is NOT considered ``empty()`` by the PHP interpreter.
					 *
					 *    Using an array of multiple type hints.
					 *    Example: ``check_arg_types(array('string', 'object'), func_get_args())``.
					 *    Example: ``check_arg_types(array('string:!empty', 'object'), func_get_args())``.
					 *    Allows either a string `OR` an object to be passed in as the first argument value.
					 *    In the second example, we allow a string (NOT empty) `OR` an object instance.
					 *
					 *    Array w/ an empty type hint value (NOT recommended).
					 *    Example: ``check_arg_types(array('string', ''), func_get_args())``.
					 *    Allows a string, or anything else (so actually, anything is allowed here).
					 *    It would be VERY odd to do this. Just documenting this behavior for the sake of clarity.
					 *
					 *    Using an `[instanceof]` check.
					 *    Example: ``check_arg_types('\\websharks_core_v000000_dev\\users', func_get_args())``.
					 *    Example: ``check_arg_types(array('WP_User', '\\websharks_core_v000000_dev\\users'), func_get_args())``.
					 *    For practicality & performance reasons, we do NOT check `!` or `:!empty` in the case of `[instanceof]`.
					 *    It's VERY rare that one would need to require something that's NOT a specific object instance.
					 *    And, objects are NEVER empty anyway, according to PHPs ``empty()`` function.
					 *
					 * @note Ordinarily, the last argument to this method is a numerically indexed array of all arguments that were passed into the function/method we're checking.
					 *    Use ``func_get_args()`` as the last argument to this method. Example: ``check_arg_types('[type]', '[type]' ..., func_get_args())``.
					 *
					 * @warning For performance reasons, array keys in the last argument, MUST be indexed numerically.
					 *    Please make sure that ``func_get_args()`` is used as the last argument. Or, any array that uses numeric indexes, is also fine.
					 *    Associative arrays will cause PHP notices, due to undefined indexes. We're expecting a numerically indexed array of arguments here.
					 *
					 * @note If the last argument to this method is an integer, instead of an array; we treat the last argument as the number of required arguments.
					 *    Example: ``check_arg_types('[type]', '[type]' ..., func_get_args(), 2)``. This requires a minimum of two argument values.
					 *    This is NOT needed in most cases. PHP should have already triggered a warning about missing arguments.
					 *
					 * @return boolean TRUE if all argument values can be validated against the list of type hints; else an exception is thrown.
					 *
					 * @throws exception If the last parameter is an integer indicating a number of required arguments,
					 *    and the number of arguments passed in, is less than this number.
					 *
					 * @throws exception If even ONE argument is passed incorrectly.
					 *
					 * @assert ('string', 'array', 'object', array('', array(), 'string-not-object')) throws exception
					 * @assert ('string', array('hello'), 1) === TRUE
					 * @assert ('string', array('hello'), 2) throws exception
					 * @assert (':!empty', array('')) throws exception
					 * @assert (':!empty', 1) === TRUE
					 * @assert (array('string', 'object'), 'array', 'object', array(new \stdClass)) === TRUE
					 * @assert (array('string', 'object'), 'array', 'object', array('')) === TRUE
					 * @assert (array('string', 'object', 'integer', 'float'), 'array', 'object', array(1)) === TRUE
					 * @assert ('string', array('string', 'object', 'integer', 'float'), 'object', array('', new \stdClass)) === TRUE
					 * @assert ('string', array('object', 'null'), 'object', array('', new \stdClass)) === TRUE
					 * @assert ('string', array('object', 'null'), 'object', array('', NULL)) === TRUE
					 * @assert ('string', array('null', 'object'), 'object', array('', NULL)) === TRUE
					 * @assert ('string', array('object', 'null'), 'object', array('', 1)) throws exception
					 * @assert ('string', '!object', 'object', array('', new \stdClass)) throws exception
					 * @assert ('string', '!object', 'object', array('', 12)) === TRUE
					 * @assert ('!string', '!object', 'object', array(new \stdClass, 12)) === TRUE
					 * @assert (array('!string','!object'), array('!integer','!object'), 'object', array(new \stdClass, 12)) === TRUE
					 * @assert (array('integer','!object'), 'object', array(new \stdClass)) throws exception
					 * @assert (array('integer','!object','integer'), 'object', array(1)) === TRUE
					 * @assert ('string', 'array', 'object', array('')) === TRUE
					 * @assert ('string:!empty', array('hello')) === TRUE
					 * @assert ('string', 'array', 'object', array('', new \stdClass)) throws exception
					 * @assert ('string', 'array', 'object', array(array())) throws exception
					 * @assert ('string', 'array', 'object', array(1)) throws exception
					 * @assert ('scalar', 'array', 'object', array(1)) === TRUE
					 * @assert ('scalar', 'array', 'object', array(0.1)) === TRUE
					 * @assert ('numeric', 'array', 'object', array(0.1)) === TRUE
					 * @assert ('numeric', 'array', 'object', array('1.2')) === TRUE
					 * @assert ('WP_User', 'array', 'object', array(new \WP_User)) === TRUE
					 * @assert ('WP_User', 'array', 'object', array('WP_User')) throws exception
					 * @assert ('string:!empty', array('')) throws exception
					 * @assert (array('string:!empty','array:!empty'), array(0, array())) throws exception
					 * @assert (array('string:!empty','array:!empty'), array('0')) throws exception
					 * @assert (array('string:!empty','array:!empty'), array(array('hello'))) === TRUE
					 * @assert (array('string:!empty','array:!empty'), array('hello')) === TRUE
					 * @assert (array('null','integer:!empty','\\websharks_core_v000000_dev\\users'), array($this->object->©user)) === TRUE
					 *
					 * @assert $args = array('', array(), new \stdClass, 1.0, 1, TRUE, tmpfile(), 'anything', 'scalar-string', 1, 1.2, '1.2', 1.2, 1, NULL, 'hello', array());
					 *    ('string', 'array', 'object', 'float', 'integer', 'boolean', 'resource', '', 'scalar', 'scalar', 'scalar', 'numeric', 'numeric', 'numeric', 'null', 'string:!empty', '!string', $args) === TRUE
					 */
					final public function check_arg_types()
						{
							$_arg_type_hints__args__required_args = func_get_args();
							$_last_arg_value                      = array_pop($_arg_type_hints__args__required_args);
							$required_args                        = 0; // Default number of required arguments.

							if(is_integer($_last_arg_value)) // Required arguments?
								{
									$required_args = $_last_arg_value; // Number of required arguments.
									$args          = (array)array_pop($_arg_type_hints__args__required_args);
								}
							else $args = (array)$_last_arg_value; // Use ``$_last_arg_value`` as ``$args``.

							$arg_type_hints      = $_arg_type_hints__args__required_args; // Type hints (remaining arguments).
							$total_args          = count($args); // Total arguments passed into the function/method we're checking.
							$total_arg_positions = $total_args - 1; // Based on total number of arguments.

							# Commenting this out for performance. It's not absolutely necessary.
							# unset($_arg_type_hints__args__required_args, $_last_arg_value);

							if($total_args < $required_args) // Forcing a minimum number of arguments?
								// This is NOT needed in most cases. PHP should have already triggered a warning about missing arguments.
								// However, this CAN be useful in certain scenarios, where we want to absolutely enforce required arguments.
								{
									throw $this->©exception(
										__METHOD__.'#args_missing', compact('arg_type_hints', 'args', 'required_args'),
										sprintf($this->i18n('Missing required argument(s); `%1$s` requires `%2$s`, `%3$s` given.'),
										        $this->©method->get_backtrace_callers(debug_backtrace(), 'last'), $required_args, $total_args).
										sprintf($this->i18n(' Got: `%1$s`.'), $this->©var->dump($args))
									);
								}
							else if($total_args === 0) // No arguments (no problem).
								return TRUE; // We can stop right here in this case.

							foreach($arg_type_hints as $_arg_position => $_arg_type_hints)
								{
									if($_arg_position > $total_arg_positions) // Argument not even passed in?
										continue; // Argument was not even passed in (we don't need to check this value).

									unset($_last_arg_type_key); // Unset before iterating (we'll define below, if necessary).

									foreach(($_arg_types = (array)$_arg_type_hints) as $_arg_type_key => $_arg_type)
										{
											switch(($_arg_type = (string)$_arg_type)) // Checks type requirements.
											{
												case '': // Anything goes (there are NO requirements).
														break 2; // We have a valid type/value here.

												/****************************************************************************/

												case ':!empty': // Anything goes. But check if it's empty.
														if(empty($args[$_arg_position])) // Is empty?
															{
																if(!isset($_last_arg_type_key))
																	$_last_arg_type_key = count($_arg_types) - 1;

																if($_arg_type_key === $_last_arg_type_key)
																	// Exhausted list of possible types.
																	{
																		$problem = array(
																			'types'    => $_arg_types,
																			'position' => $_arg_position,
																			'value'    => $args[$_arg_position],
																			'empty'    => empty($args[$_arg_position])
																		);
																		break 3; // We DO have a problem here.
																	}
															}
														else break 2; // We have a valid type/value here.

														break 1; // Default break 1; and continue type checking.

												/****************************************************************************/

												case 'string': // All of these fall under ``!is_...()`` checks.
												case 'boolean':
												case 'bool':
												case 'integer':
												case 'int':
												case 'float':
												case 'real':
												case 'double':
												case 'numeric':
												case 'scalar':
												case 'array':
												case 'object':
												case 'resource':
												case 'null':

														$is_ = static::$___is_type_checks[$_arg_type];
														/** @var $is_ string */

														if(!$is_($args[$_arg_position])) // Not this type?
															{
																if(!isset($_last_arg_type_key))
																	$_last_arg_type_key = count($_arg_types) - 1;

																if($_arg_type_key === $_last_arg_type_key)
																	// Exhausted list of possible types.
																	{
																		$problem = array(
																			'types'    => $_arg_types,
																			'position' => $_arg_position,
																			'value'    => $args[$_arg_position],
																			'empty'    => empty($args[$_arg_position])
																		);
																		break 3; // We DO have a problem here.
																	}
															}
														else break 2; // We have a valid type/value here.

														break 1; // Default break 1; and continue type checking.

												/****************************************************************************/

												case '!string': // All of these fall under ``is_...()`` checks.
												case '!boolean':
												case '!bool':
												case '!integer':
												case '!int':
												case '!float':
												case '!real':
												case '!double':
												case '!numeric':
												case '!scalar':
												case '!array':
												case '!object':
												case '!resource':
												case '!null':

														$is_ = static::$___is_type_checks[$_arg_type];
														/** @var $is_ string */

														if($is_($args[$_arg_position])) // Is this type?
															{
																if(!isset($_last_arg_type_key))
																	$_last_arg_type_key = count($_arg_types) - 1;

																if($_arg_type_key === $_last_arg_type_key)
																	// Exhausted list of possible types.
																	{
																		$problem = array(
																			'types'    => $_arg_types,
																			'position' => $_arg_position,
																			'value'    => $args[$_arg_position],
																			'empty'    => empty($args[$_arg_position])
																		);
																		break 3; // We DO have a problem here.
																	}
															}
														else break 2; // We have a valid type/value here.

														break 1; // Default break 1; and continue type checking.

												/****************************************************************************/

												case 'string:!empty': // These are ``!is_...()`` || ``empty()`` checks.
												case 'boolean:!empty':
												case 'bool:!empty':
												case 'integer:!empty':
												case 'int:!empty':
												case 'float:!empty':
												case 'real:!empty':
												case 'double:!empty':
												case 'numeric:!empty':
												case 'scalar:!empty':
												case 'array:!empty':
												case 'object:!empty':
												case 'resource:!empty':
												case 'null:!empty':

														$is_ = static::$___is_type_checks[$_arg_type];
														/** @var $is_ string */

														if(!$is_($args[$_arg_position]) || empty($args[$_arg_position]))
															// Now, have we exhausted the list of possible types?
															{
																if(!isset($_last_arg_type_key))
																	$_last_arg_type_key = count($_arg_types) - 1;

																if($_arg_type_key === $_last_arg_type_key)
																	// Exhausted list of possible types.
																	{
																		$problem = array(
																			'types'    => $_arg_types,
																			'position' => $_arg_position,
																			'value'    => $args[$_arg_position],
																			'empty'    => empty($args[$_arg_position])
																		);
																		break 3; // We DO have a problem here.
																	}
															}
														else break 2; // We have a valid type/value here.

														break 1; // Default break 1; and continue type checking.

												/****************************************************************************/

												default: // Assume object `instanceof` in this default case handler.
													// For practicality & performance reasons, we do NOT check `!` or `:!empty` here.
													// It's VERY rare that one would need to require something that's NOT a specific object instance.
													// Objects are NEVER empty anyway, according to PHPs ``empty()`` function.

													if(!($args[$_arg_position] instanceof $_arg_type))
														{
															if(!isset($_last_arg_type_key))
																$_last_arg_type_key = count($_arg_types) - 1;

															if($_arg_type_key === $_last_arg_type_key)
																// Exhausted list of possible types.
																{
																	$problem = array(
																		'types'    => $_arg_types,
																		'position' => $_arg_position,
																		'value'    => $args[$_arg_position],
																		'empty'    => empty($args[$_arg_position])
																	);
																	break 3; // We DO have a problem here.
																}
														}
													else break 2; // We have a valid type for this arg.

													break 1; // Default break 1; and continue type checking.
											}
										}
								}
							# Commenting this out for performance. It's not absolutely necessary.
							# unset($_arg_position, $_arg_type_hints, $_arg_types, $_arg_type_key, $_last_arg_type_key, $_arg_type, $is_, $_negating, $_checking_if_empty);

							if(!empty($problem)) // We have a problem!
								{
									$position   = $problem['position'] + 1;
									$types      = implode('|', $problem['types']);
									$empty      = ($problem['empty']) ? $this->i18n('empty').' ' : '';
									$type_given = (is_object($problem['value'])) ? get_class($problem['value']) : gettype($problem['value']);

									throw $this->©exception(
										__METHOD__.'#invalid_args', compact('arg_type_hints', 'args', 'required_args'),
										sprintf($this->i18n('Argument #%1$s passed to `%2$s` requires `%3$s`, %4$s`%5$s` given.'),
										        $position, $this->©method->get_backtrace_callers(debug_backtrace(), 'last'), $types, $empty, $type_given).
										sprintf($this->i18n(' Got: `%1$s`.'), $this->©var->dump($args))
									);
								}
							return TRUE; // Default return value (no problem).
						}

					/**
					 * Checks intersecting arguments against a list of type hints (and extends defaults).
					 *
					 * @note Very important for this method to remain HIGHLY optimized at all times.
					 *    This method is called MANY times throughout the entire WebSharks™ Core framework.
					 *
					 * @final May NOT be overridden by extenders.
					 *
					 * @params-variable-length This method accepts any number of parameters (i.e. type hints, as seen below).
					 *
					 * @note Arguments to this method should first include a variable-length list of type hints.
					 *
					 *    Format as follows: ``check_extension_arg_types('[type]', '[type]' ..., $default_args, $args)``.
					 *    Where type hint arguments MUST be ordered exactly the same as each argument in the array of ``$default_args``.
					 *    However, it's fine to exclude certain arguments from the end (i.e. any we don't need to check), or via exclusion w/ an empty string.
					 *    This method uses ``check_arg_types()``. Please see ``check_arg_types()`` to learn more about type hints in the WebSharks™ Core.
					 *
					 * @note Ordinarily, the last argument to this method is an associative array of all arguments that were passed in through a single function/method parameter.
					 *    For example: ``check_extension_arg_types('[type]', '[type]' ..., $default_args, array('hello' => 'hello', 'world' => 'world')``.
					 *
					 * @note If the last argument to this method is an integer, instead of an array; we treat the last argument as the number of required arguments.
					 *    Example: ``check_extension_arg_types('[type]', '[type]' ..., $default_args, $args, 2)``. This requires a minimum of two argument values.
					 *    Required argument keys, are those which appear first in the array of ``$default_args`` (e.g. always based on default argument key positions).
					 *
					 * @return array Returns an array of extended ``$default_args``, if all argument values can be validated against the list of type hints.
					 *    Note: the ``$default_args`` are extended with ``array_merge()``. Otherwise, an exception is thrown when there are problems.
					 *
					 * @throws exception If the last parameter is an integer indicating a number of required arguments,
					 *    and the number of arguments passed in, is less than this number.
					 *
					 * @throws exception If even ONE argument is passed incorrectly.
					 *
					 * @assert $default_args = array('hello' => 'hello', 'world' => 'world');
					 *    $args = array('hello' => 'hi', 'hi' => 'there');
					 *    ('string:!empty', $default_args, $args) === array('hello' => 'hi', 'world' => 'world')
					 *
					 * @assert $default_args = array('hello' => 'hello', 'world' => 'world');
					 * // Note: array keys that do NOT intersect, are automatically ignored by this routine (intentionally).
					 * // In this case, the `hi` element is completely removed, before we check arg types and/or extend the defaults.
					 *    $args = array('hello' => 'hi', 'hi' => 'there'); // The `hi` element does NOT exist in ``$default_args``.
					 *    ('string:!empty', $default_args, $args, 2) throws exception
					 */
					final public function check_extension_arg_types()
						{
							$_arg_type_hints__default_args__args__required_args = func_get_args();
							$_last_arg_value                                    = array_pop($_arg_type_hints__default_args__args__required_args);
							$required_args                                      = 0; // Default number of required arguments.

							if(is_integer($_last_arg_value)) // Do we have required arguments in the last position?
								{
									$required_args = $_last_arg_value; // Number of required arguments.
									$args          = (array)array_pop($_arg_type_hints__default_args__args__required_args);
								}
							else $args = (array)$_last_arg_value; // Use ``$_last_arg_value`` as ``$args``.

							$default_args   = (array)array_pop($_arg_type_hints__default_args__args__required_args);
							$arg_type_hints = $_arg_type_hints__default_args__args__required_args; // Remaining arguments (type hints).

							# Commenting this out for performance. It's not absolutely necessary.
							# unset($_arg_type_hints__default_args__args__required_args, $_last_arg_value);

							// Initializes several important arrays that we're building below.

							$default_arg_key_positions = $extension_args = $intersecting_args = $intersecting_arg_type_hints = array();

							// Builds a legend of default argument key positions; and checks for missing argument keys.

							foreach(array_keys($default_args) as $_default_arg_key_position => $_default_arg_key)
								{
									$default_arg_key_positions[$_default_arg_key] = // Numeric indexes.
										$_default_arg_key_position; // This builds a legend for routines below.

									if( // Checks required argument keys.
										$_default_arg_key_position < $required_args && !array_key_exists($_default_arg_key, $args)
									)
										// Missing a required argument (e.g. key is missing completely).
										{
											throw $this->©exception(
												__METHOD__.'#args_missing', compact('arg_type_hints', 'default_args', 'args', 'required_args'),
												sprintf($this->i18n('`%1$s` requires missing argument `%2$s`.'),
												        $this->©method->get_backtrace_callers(debug_backtrace(), 'last'), $_default_arg_key).
												sprintf($this->i18n(' Got: `%1$s`.'), $this->©var->dump($args))
											);
										}
								}
							# Commenting this out for performance. It's not absolutely necessary.
							# unset($_default_arg_key_position, $_default_arg_key); // Just a little housekeeping.

							// Constructs ``$extension_args``, ``$intersecting_args``, and ``$intersecting_arg_type_hints``.

							foreach(array_intersect_key($default_args, $args) as $_default_arg_key => $_default_arg)
								{
									$extension_args[$_default_arg_key] = & $args[$_default_arg_key];
									$intersecting_args[]               = & $args[$_default_arg_key];

									if(isset($arg_type_hints[$default_arg_key_positions[$_default_arg_key]]))
										$intersecting_arg_type_hints[] = & $arg_type_hints[$default_arg_key_positions[$_default_arg_key]];
								}

							# Commenting this out for performance. It's not absolutely necessary here.
							# unset($_default_arg_key, $_default_arg); // Unset temporary vars. Just a little housekeeping.

							// Now we put everything together (into a single array); and ``check_arg_types()``.

							$arg_type_hints__args   = $intersecting_arg_type_hints;
							$arg_type_hints__args[] = & $intersecting_args;

							call_user_func_array( // Checks argument types.
								array($this, 'check_arg_types'), $arg_type_hints__args);

							// Return extended arguments now.
							return array_merge($default_args, $extension_args);
						}

					/**
					 * Sets properties on ``$this`` object instance.
					 *
					 * @final May NOT be overridden by extenders.
					 *
					 * @param array $properties An associative array of object instance properties.
					 *    Each property MUST already exist, and value types MUST match up.
					 *
					 * @throws exception If invalid types are passed through arguments list.
					 * @throws exception If attempting to set an undefined property (i.e. non-existent).
					 * @throws exception If attempting to set a property value, which has a different value type.
					 *    Properties with an existing NULL value, are an exception to this rule.
					 *    If an existing property ``is_null()``, we allow ANY new value type.
					 *
					 * @assert (array('___instance_config' => $this->object->___instance_config)) === TRUE
					 */
					final public function set_properties($properties = array())
						{
							$this->check_arg_types('array', func_get_args());

							foreach($properties as $_property => $_value)
								{
									if(property_exists($this, $_property))
										{
											if(is_null($this->$_property) || gettype($_value) === gettype($this->$_property))
												$this->$_property = $_value; // Sets/updates existing property value.

											else throw $this->©exception( // Invalid property type (MUST throw exception).
												__METHOD__.'#invalid_property_type', compact('_property', '_value', 'properties'),
												sprintf($this->i18n('Property type mismatch for property name: `%1$s`.'), $_property).
												sprintf($this->i18n(' Should be `%1$s`, `%2$s` given.'), gettype($this->$_property), gettype($_value))
											);
										}
									else throw $this->©exception( // Property is NOT already defined (MUST throw exception).
										__METHOD__.'#undefined_property', compact('_property', '_value', 'properties'),
										sprintf($this->i18n('Attempting to set undefined property: `%1$s`.'), $_property)
									);
								}
							unset($_property, $_value); // A little housekeeping.
						}

					/**
					 * Fires WordPress® Action Hooks for ``$this`` class.
					 *
					 * Action Hooks can be fired using a simple call to ``$this->do_action()``.
					 *
					 * Automatically prefixes hook/filter names with the calling `namespace_stub__sub_namespace__class__`.
					 * This allows for hooks/filters to be written with short names inside class methods, while still being
					 * given a consistently unique `namespace_stub__sub_namespace__class__` prefix.
					 *
					 * The `namespace_stub__sub_namespace__class__` slug will always start with the plugin's root namespace stub,
					 * so that every hook/filter implemented by a plugin contains the same prefix,
					 * regardless of which namespace ``$this`` class is actually in.
					 *
					 * For example, if a hook/filter is fired by ``$this`` class `websharks_core_v000000_dev\framework`,
					 * the hook/filter slug is prefixed by: ``$this->___instance_config->plugin_stub_as_root_ns_class_with_underscores``.
					 * Which will result in this hook/filter name: `plugin_root_ns_stub__framework__hook_filter_name`.
					 *
					 * In the case of a sub-namespace, it works the same way.
					 * The actual root namespace is swapped out, in favor of the plugin's root namespace stub.
					 * If a hook/filter is fired by ``$this`` class `websharks_core_v000000_dev\sub_namespace\class`,
					 * the hook/filter slug is prefixed again by: ``$this->___instance_config->plugin_stub_as_root_ns_class_with_underscores``.
					 * Which will result in this hook/filter name: `plugin_root_ns_stub__sub_namespace__class__hook_filter_name`.
					 *
					 * @final May NOT be overridden by extenders.
					 *
					 * @param string $action Action Hook name.
					 * @params-variable-length
					 *
					 * @return string Action Hook name, for ``$this`` class.
					 *    Useful only in debugging.
					 *
					 * @assert ('action') === 'websharks_core__framework__action'
					 * @assert ('action', get_defined_vars()) === 'websharks_core__framework__action'
					 */
					final public function do_action($action)
						{
							// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since Action Hooks already slow things down, we bypass all we can for speed here.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$args    = func_get_args(); // Get all of the arguments (we'll need these below).
							$args[0] = (string)$args[0]; // Typecasting this to a string value.

							$args[0] = $this->___instance_config->plugin_stub_as_root_ns_class_with_underscores.'__'.$args[0];

							call_user_func_array('do_action', $args);

							return $args[0];
						}

					/**
					 * Fires WordPress® Filters for ``$this`` class.
					 *
					 * Filters can be fired using a simple call to ``$this->apply_filters()``.
					 *
					 * Automatically prefixes hook/filter names with the calling `namespace_stub__sub_namespace__class__`.
					 * This allows for hooks/filters to be written with short names inside class methods, while still being
					 * given a consistently unique `namespace_stub__sub_namespace__class__` prefix.
					 *
					 * The `namespace_stub__sub_namespace__class__` slug will always start with the plugin's root namespace stub,
					 * so that every hook/filter implemented by a plugin contains the same prefix,
					 * regardless of which namespace ``$this`` class is actually in.
					 *
					 * For example, if a hook/filter is fired by ``$this`` class `websharks_core_v000000_dev\framework`,
					 * the hook/filter slug is prefixed by: ``$this->___instance_config->plugin_stub_as_root_ns_class_with_underscores``.
					 * Which will result in this hook/filter name: `plugin_root_ns_stub__framework__hook_filter_name`.
					 *
					 * In the case of a sub-namespace, it works the same way.
					 * The actual root namespace is swapped out, in favor of the plugin's root namespace stub.
					 * If a hook/filter is fired by ``$this`` class `websharks_core_v000000_dev\sub_namespace\class`,
					 * the hook/filter slug is prefixed again by: ``$this->___instance_config->plugin_stub_as_root_ns_class_with_underscores``.
					 * Which will result in this hook/filter name: `plugin_root_ns_stub__sub_namespace__class__hook_filter_name`.
					 *
					 * @final May NOT be overridden by extenders.
					 *
					 * @param string $filter Filter name.
					 * @param mixed  $value Value to Filter.
					 * @params-variable-length
					 *
					 * @return mixed Performed Filter return value.
					 *
					 * @assert ('filter', 'value') === 'value'
					 * @assert ('filter', 'value', get_defined_vars()) === 'value'
					 */
					final public function apply_filters($filter, $value)
						{
							// Bypassing ``is_string()``, ``check_arg_types()`` and NON-empty check here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since Filters already slow things down, we bypass all we can for speed here.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$args    = func_get_args(); // Get all of the arguments (we'll need these below).
							$args[0] = (string)$args[0]; // Typecasting this to a string value.

							$args[0] = $this->___instance_config->plugin_stub_as_root_ns_class_with_underscores.'__'.$args[0];

							return call_user_func_array('apply_filters', $args);
						}

					/**
					 * Contextual translation wrapper for ``$this`` class (context: admin-side).
					 *
					 * Translations can be performed with a simple call to ``$this->i18n()``.
					 *
					 * Automatically prefixes contextual slugs with the calling `namespace-stub--sub-namespace--`.
					 * This allows for translations to be performed with a simple call to ``$this->i18n()``, while still being
					 * given a consistently unique `namespace-stub--sub-namespace--` prefix.
					 *
					 * The `namespace-stub--sub-namespace--` slug will always start with the plugin's root namespace-stub,
					 * so that every translation call implemented by a plugin contains the same prefix,
					 * regardless of which namespace ``$this`` class is actually in.
					 *
					 * For example, if a translation call is fired by ``$this`` class `websharks_core_v000000_dev\framework`,
					 * the contextual slug prefix is: ``$this->___instance_config->plugin_stub_as_root_ns_with_dashes``.
					 * Which would result in this contextual slug: `plugin-root-ns-stub--(front|admin)-side`.
					 *
					 * In the case of a sub-namespace, it works the same way.
					 * The actual root namespace is swapped out, in favor of the plugin's root namespace stub.
					 * So if a translation call is fired by ``$this`` class `websharks_core_v000000_dev\sub_namespace\class`,
					 * the contextual slug prefix is again: ``$this->___instance_config->plugin_stub_as_root_ns_with_dashes``.
					 * Which would result in this contextual slug: `plugin-root-ns-stub--sub-namespace--(front|admin)-side`.
					 *
					 * This dynamic behavior, when used for contextual slug prefixes, might make it easier for translators.
					 * For instance, in some cases, sub-namespaces might contain code which wraps up a particular set of features,
					 * which may or may NOT be used by all site owners. If you want to make it easier/simpler for plugin translators,
					 * place any code for extra/optional features into its own sub-namespace. This way translators can optionally bypass
					 * certain contextual slugs (perhaps saving them a tremendous amount of time).
					 *
					 * @final This method may NOT be overridden by extenders.
					 *
					 * @param string  $string String to translate.
					 *
					 * @param string  $other_contextuals Optional. Other contextual slugs relevant to this translation.
					 *    Contextual slugs normally follow the standard of being written with dashes.
					 *
					 * @return string Translated string.
					 *
					 * @assert ('hello world') === 'hello world'
					 * @assert ('hello world', 'foo') === 'hello world'
					 * @assert ('hello world', 'foo') === 'hello world'
					 */
					final public function i18n($string, $other_contextuals = '')
						{
							// Bypassing ``is_...()`` and ``check_arg_types()`` here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since translation already slows things down, we bypass all we can for speed here.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$string            = (string)$string; // Typecasting this to a string value.
							$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
							$context           = $this->___instance_config->plugin_stub_as_root_ns_with_dashes.'--admin-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

							return _x($string, $context, $this->___instance_config->plugin_root_ns_stub_with_dashes);
						}

					/**
					 * Plural/contextual translation wrapper for ``$this`` class (context: admin-side).
					 *
					 * Plural translations can be performed with a simple call to ``$this->i18n_p()``.
					 *
					 * @methods-similar See ``$this->i18n()`` for further details on functionality.
					 *
					 * @final This method may NOT be overridden by extenders.
					 *
					 * @param string          $string_singular String to translate (in singular format).
					 * @param string          $string_plural String to translate (in plural format).
					 * @param string|integer  $numeric_value Value to translate (always a numeric value).
					 *
					 * @param string          $other_contextuals Optional. Other contextual slugs relevant to this translation.
					 *    Contextual slugs normally follow the standard of being written with dashes.
					 *
					 * @return string Translated string.
					 *
					 * @assert ('hello world', 'hello worlds', 2) === 'hello worlds'
					 * @assert ('hello world', 'hello worlds', 0) === 'hello worlds'
					 * @assert ('hello world', 'hello worlds', 1) === 'hello world'
					 */
					final public function i18n_p($string_singular, $string_plural, $numeric_value, $other_contextuals = '')
						{
							// Bypassing ``is_...()`` and ``check_arg_types()`` here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since translation already slows things down, we bypass all we can for speed here.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$string_singular   = (string)$string_singular; // Typecasting this to a string value.
							$string_plural     = (string)$string_plural; // Typecasting this to a string value.
							$numeric_value     = (string)$numeric_value; // Typecasting this to a string value (numeric string).
							$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
							$context           = $this->___instance_config->plugin_stub_as_root_ns_with_dashes.'--admin-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

							return _nx($string_singular, $string_plural, $numeric_value, $context, $this->___instance_config->plugin_root_ns_stub_with_dashes);
						}

					/**
					 * Contextual translation wrapper for ``$this`` class (context: front-side).
					 *
					 * Translations can be performed with a simple call to ``$this->translate()``.
					 *
					 * @methods-similar See ``$this->i18n()`` for further details on functionality.
					 *
					 * @final This method may NOT be overridden by extenders.
					 *
					 * @param string  $string String to translate.
					 *
					 * @param string  $other_contextuals Optional. Other contextual slugs relevant to this translation.
					 *    Contextual slugs normally follow the standard of being written with dashes.
					 *
					 * @return string Translated string.
					 *
					 * @assert ('hello world') === 'hello world'
					 * @assert ('hello world', 'foo') === 'hello world'
					 * @assert ('hello world', 'foo') === 'hello world'
					 */
					final public function translate($string, $other_contextuals = '')
						{
							// Bypassing ``is_...()`` and ``check_arg_types()`` checks here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since translation already slows things down, we bypass all we can for speed here.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$string            = (string)$string; // Typecasting this to a string value.
							$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
							$context           = $this->___instance_config->plugin_stub_as_root_ns_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

							return _x($string, $context, $this->___instance_config->plugin_root_ns_stub_with_dashes);
						}

					/**
					 * Plural/contextual translation wrapper for ``$this`` class (context: front-side).
					 *
					 * Plural translations can be performed with a simple call to ``$this->translate_p()``.
					 *
					 * @methods-similar See ``$this->i18n()`` for further details on functionality.
					 *
					 * @final This method may NOT be overridden by extenders.
					 *
					 * @param string          $string_singular String to translate (in singular format).
					 * @param string          $string_plural String to translate (in plural format).
					 * @param string|integer  $numeric_value Value to translate (always a numeric value).
					 *
					 * @param string          $other_contextuals Optional. Other contextual slugs relevant to this translation.
					 *    Contextual slugs normally follow the standard of being written with dashes.
					 *
					 * @return string Translated string.
					 *
					 * @assert ('hello world', 'hello worlds', 2) === 'hello worlds'
					 * @assert ('hello world', 'hello worlds', 0) === 'hello worlds'
					 * @assert ('hello world', 'hello worlds', 1) === 'hello world'
					 */
					final public function translate_p($string_singular, $string_plural, $numeric_value, $other_contextuals = '')
						{
							// Bypassing ``is_...()`` and ``check_arg_types()`` here, in favor of typecasting.
							// Benchmark tests show a slight increase in performance this way, and since translation already slows things down, we bypass all we can for speed here.
							// Worst case scenario, something attempts to pass an object, and PHP will throw an error about string conversion (which is good enough).

							$string_singular   = (string)$string_singular; // Typecasting this to a string value.
							$string_plural     = (string)$string_plural; // Typecasting this to a string value.
							$numeric_value     = (string)$numeric_value; // Typecasting this to a string value (numeric string).
							$other_contextuals = (string)$other_contextuals; // Typecasting this to a string value.
							$context           = $this->___instance_config->plugin_stub_as_root_ns_with_dashes.'--front-side'.(($other_contextuals) ? ' '.$other_contextuals : '');

							return _nx($string_singular, $string_plural, $numeric_value, $context, $this->___instance_config->plugin_root_ns_stub_with_dashes);
						}
				}

				/**
				 * Centralized autoload handler.
				 *
				 * @note Calls ``spl_autoload_register()``.
				 */
				include_once dirname(__FILE__).'/autoloader.php';

				/**
				 * Centralized exception handler.
				 *
				 * @note Calls ``set_exception_handler()``.
				 */
				include_once dirname(__FILE__).'/exception-handler.php';

				/**
				 * Creates global framework instance.
				 *
				 * @var framework $GLOBALS[__NAMESPACE__] Global framework instance.
				 */
				$GLOBALS[__NAMESPACE__] = new framework(
					array(
					     'plugin_var_ns'         => 'websharks_core',
					     'plugin_root_ns'        => __NAMESPACE__,
					     'plugin_name'           => 'WebSharks™ Core',
					     'plugin_version'        => '000000-dev', #!version!#
					     'plugin_dir'            => dirname(dirname(dirname(__FILE__))),
					     'plugin_site'           => 'http://www.websharks-inc.com',
					     'dynamic_class_aliases' => framework::$___dynamic_class_aliases
					));
				if(!isset($GLOBALS['websharks_core']->___instance_config->core_version)
				   || version_compare($GLOBALS['websharks_core']->___instance_config->core_version,
				                      $GLOBALS[__NAMESPACE__]->___instance_config->core_version, '<')
				) $GLOBALS['websharks_core'] = $GLOBALS[__NAMESPACE__];
			}
	}
namespace // Global namespace.
	{
		if(!class_exists('websharks_core'))
			{
				/**
				 * WebSharks™ Core.
				 */
				class websharks_core extends
					\websharks_core_v000000_dev\framework
				{
					// Easier access to those w/o concern for versions.
				}
			}
		if(!function_exists('websharks_core'))
			{
				/**
				 * WebSharks™ Core instance.
				 *
				 * @return \websharks_core_v000000_dev\framework
				 *  Or the latest version available at runtime (in the case of multiple instances).
				 */
				function websharks_core()
					{
						return $GLOBALS['websharks_core'];
					}
			}
	}