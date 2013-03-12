<?php
/**
 * Database Utilities.
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
		 * Database Utilities.
		 *
		 * @package WebSharks\Core
		 * @since 120318
		 *
		 * @assert ($GLOBALS[__NAMESPACE__])
		 */
		class db_utils extends framework
		{
			/**
			 * @var array Array of CRON jobs associated with this class.
			 */
			public $cron_jobs = array
			(
				array(
					'©class.method' => '©db_utils.cleanup_expired_transients',
					'schedule'      => 'daily'
				)
			);

			/**
			 * Handles loading sequence.
			 *
			 * @attaches-to WordPress® `wp_loaded` action hook.
			 * @hook-priority `10000`.
			 *
			 * @return null Nothing.
			 *
			 * @assert () === NULL
			 */
			public function wp_loaded()
				{
					$this->©crons->config($this->cron_jobs);
				}

			/**
			 * Prepares meta names/values.
			 *
			 * @param mixed $value Any mixed data value is fine.
			 *
			 * @note Very important for this routine to ALLOW empty values.
			 *    Sometimes meta values are suppose to be empty.
			 *
			 * @return array Array of name/value pairs (the array is NEVER empty).
			 *
			 * @assert ('') === array(array('name' => '0', 'value' => ''))
			 * @assert (array()) === array(array('name' => '0', 'value' => ''))
			 * @assert (array('hello' => 'there')) === array(array('name' => 'hello', 'value' => 'there'))
			 */
			public function metafy($value)
				{
					$value = (array)$this->©array->ify_deep($value);

					foreach($value as $_name => $_value)
						{
							if(is_array($_value))
								$_value = serialize($_value);

							if(is_numeric($_name))
								$_name = '_'.(string)$_name;

							$meta[$_name] = (string)$_value;
						}
					unset($_name, $_value);

					if(empty($meta))
						$meta['_0'] = (string)$value;

					return $meta;
				}

			/**
			 * Prepares query for meta table insertions (or updates).
			 *
			 * @param string  $table Unprefixed table name.
			 * @param string  $rel_id_column Column name for related ID.
			 * @param string  $rel_id Value for the related ID column.
			 *
			 * @param mixed   $data Any mixed data value is fine.
			 *    This will be passed through ``metafy()``. Converts to an array of name/value pairs.
			 *
			 * @param boolean $update_on_duplicate_key Optional. Defaults to a FALSE value.
			 *    If this is TRUE, meta values/times are updated when/if a duplicate key is encountered during insertion.
			 *    Meta tables should each have a UNIQUE index based on their ``$rel_id_column`` and `name` columns.
			 *
			 * @return string A full MySQL query, with one or more meta table insertions (NEVER empty).
			 *    The query returned by this routine, can be fired in a single shot (inserts/updates multiple rows).
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$table``, ``$rel_id_column``, or ``$rel_id`` are empty.
			 * @throws exception If ``$table`` is invalid (i.e. non-existent).
			 * @throws exception If unable to generate meta name/value pairs.
			 *
			 * @assert ('___unit_test_table', 'rel_id', 1, array()) === "INSERT INTO `wp_ws____unit_test_table`(`rel_id`,`name`,`value`,`time`) VALUES('1','metafy_type__array','','".time()."')"
			 * @assert ('___unit_test_table', 'rel_id', 1, array('hello' => 'there')) === "INSERT INTO `wp_ws____unit_test_table`(`rel_id`,`name`,`value`,`time`) VALUES('1','hello','there','".time()."')"
			 */
			public function prep_metafy_query($table, $rel_id_column, $rel_id, $data, $update_on_duplicate_key = FALSE)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', '', 'boolean', func_get_args());

					$query = // Prepares `_meta` table name/value insertions.
						"INSERT INTO `".$this->©string->esc_sql($this->©db_tables->get($table))."`".
						"(".$this->comma_tickify(array($rel_id_column, 'name', 'value', 'time')).")";

					$_values = array(); // Initialize.
					$_time   = time(); // Current UTC time.

					foreach($this->metafy($data) as $_name => $_value)
						$_values[] = "(".$this->comma_quotify(array($rel_id, $_name, $_value, $_time)).")";

					$query .= " VALUES".implode(',', $_values);
					unset($_time, $_name, $_value, $_values);

					if($update_on_duplicate_key)
						$query .= " ON DUPLICATE KEY UPDATE".
						          " `value` = VALUES(`value`), `time` = VALUES(`time`)";

					return $query; // Ready for DB query.
				}

			/**
			 * Gets meta value(s) from a specific meta table.
			 *
			 * @param string $table Unprefixed table name.
			 * @param string $rel_id_column Column name for related ID.
			 * @param string $rel_id Value in the related ID column.
			 * @param array  $names Name(s) associated with meta values.
			 *
			 * @return mixed If ``$names`` contains only ONE name, we simply return its meta value.
			 *    If multiple ``$names`` are requested, we return an associative array with each meta name/value.
			 *    Meta values that do NOT exist, are still included; but they default to a FALSE boolean value.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$table``, ``$rel_id_column``, or ``$rel_id`` are empty.
			 * @throws exception If ``$table`` is invalid (i.e. non-existent).
			 * @throws exception If ``$names`` is empty, or if it contains an empty or non-string value.
			 *    Meta names are ALWAYS strings (and they should NEVER be empty).
			 */
			public function get_meta_values($table, $rel_id_column, $rel_id, $names)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'array:!empty', func_get_args());

					$names       = array_unique($names);
					$count_names = count($names);
					$query_names = array();

					foreach($names as $_name)
						{
							if($this->©string->is_not_empty($_name))
								{
									if(!isset($this->cache['meta_values'][$table][$rel_id][$_name]))
										{
											$query_names[]                                       = $_name;
											$this->cache['meta_values'][$table][$rel_id][$_name] = FALSE;
										}
								}
							else throw $this->©exception(
								__METHOD__.'#invalid_name', compact('_name'),
								$this->i18n('Expecting a non-empty string `$_name` value.').
								sprintf($this->i18n(' Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->i18n('empty').' ' : ''), gettype($_name))
							);
						}
					unset($_name); // Just a little housekeeping here.

					if($query_names) // Some we don't have yet?
						{
							$query =
								"SELECT".
								" `".$this->©string->esc_sql($table)."`.`name`,".
								" `".$this->©string->esc_sql($table)."`.`value`".

								" FROM".
								" `".$this->©string->esc_sql($this->©db_tables->get($table))."` AS `".$this->©string->esc_sql($table)."`".

								" WHERE".
								" `".$this->©string->esc_sql($table)."`.`".$this->©string->esc_sql((string)$rel_id_column)."` = '".$this->©string->esc_sql((string)$rel_id)."'".
								" AND `".$this->©string->esc_sql($table)."`.`name` IN(".$this->comma_quotify($query_names).")";

							if(is_array($results = $this->©db->get_results($query, OBJECT)))
								foreach($this->typify_results_deep($results) as $_result)
									$this->cache['meta_values'][$table][$rel_id][$_result->name] = maybe_unserialize($_result->value);
							unset($_result); // A little housekeeping.
						}

					if($count_names === 1)
						return $this->cache['meta_values'][$table][$rel_id][$names[0]];

					return $this->©array->compile_key_elements_deep($this->cache['meta_values'][$table][$rel_id], $names, TRUE, 1);
				}

			/**
			 * Inserts (or updates) meta value(s); in a specific meta table.
			 *
			 * @param string  $table Unprefixed table name.
			 * @param string  $rel_id_column Column name for related ID.
			 * @param string  $rel_id Value for the related ID column.
			 * @param array   $values Associative array of meta values (e.g. key/value pairs).
			 *
			 * @return integer Number of rows affected by this insertion/update.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$table``, ``$rel_id_column``, or ``$rel_id`` are empty.
			 * @throws exception If ``$table`` is invalid (i.e. non-existent).
			 * @throws exception If ``$values`` are empty.
			 */
			public function update_meta_values($table, $rel_id_column, $rel_id, $values)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'array:!empty', func_get_args());

					foreach($values as $_name => $_value)
						{
							if($this->©string->is_not_empty($_name))
								unset($this->cache['meta_values'][$table][$rel_id][$_name]);

							else throw $this->©exception(
								__METHOD__.'#invalid_name', compact('_name'),
								$this->i18n('Expecting a non-empty string `$_name` value.').
								sprintf($this->i18n(' Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->i18n('empty').' ' : ''), gettype($_name))
							);
						}
					unset($_name, $_value); // A little housekeeping.

					return (integer)$this->©db->query(
						$this->©db_utils->prep_metafy_query(
							$table, $rel_id_column, $rel_id, $values, TRUE
						)
					);
				}

			/**
			 * Inserts new meta value(s); into a specific meta table.
			 *
			 * @param string  $table Unprefixed table name.
			 * @param string  $rel_id_column Column name for related ID.
			 * @param string  $rel_id Value for the related ID column.
			 * @param array   $values Associative array of meta values (e.g. key/value pairs).
			 *
			 * @return integer Number of rows affected by this insertion.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$table``, ``$rel_id_column``, or ``$rel_id`` are empty.
			 * @throws exception If ``$table`` is invalid (i.e. non-existent).
			 * @throws exception If ``$values`` are empty.
			 */
			public function insert_meta_values($table, $rel_id_column, $rel_id, $values)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'array:!empty', func_get_args());

					foreach($values as $_name => $_value)
						{
							if($this->©string->is_not_empty($_name))
								unset($this->cache['meta_values'][$table][$rel_id][$_name]);

							else throw $this->©exception(
								__METHOD__.'#invalid_name', compact('_name'),
								$this->i18n('Expecting a non-empty string `$_name` value.').
								sprintf($this->i18n(' Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->i18n('empty').' ' : ''), gettype($_name))
							);
						}
					unset($_name, $_value); // A little housekeeping.

					return (integer)$this->©db->query(
						$this->©db_utils->prep_metafy_query(
							$table, $rel_id_column, $rel_id, $values, FALSE
						)
					);
				}

			/**
			 * Deletes meta value(s) from a specific meta table.
			 *
			 * @param string $table Unprefixed table name.
			 * @param string $rel_id_column Column name for related ID.
			 * @param string $rel_id Value in the related ID column.
			 * @param array  $names Name(s) associated with meta values.
			 *
			 * @return integer The number of rows affected by this deletion.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$table``, ``$rel_id_column``, or ``$rel_id`` are empty.
			 * @throws exception If ``$table`` is invalid (i.e. non-existent).
			 * @throws exception If ``$names`` is empty, or if it contains an empty or non-string value.
			 *    Meta names are ALWAYS strings (and they should NEVER be empty).
			 */
			public function delete_meta_values($table, $rel_id_column, $rel_id, $names)
				{
					$this->check_arg_types('string:!empty', 'string:!empty', 'integer:!empty', 'array:!empty', func_get_args());

					foreach(($names = array_unique($names)) as $_name)
						{
							if($this->©string->is_not_empty($_name))
								unset($this->cache['meta_values'][$table][$rel_id][$_name]);

							else throw $this->©exception(
								__METHOD__.'#invalid_name', compact('_name'),
								$this->i18n('Expecting a non-empty string `$_name` value.').
								sprintf($this->i18n(' Got: %1$s`%2$s`.'), ((empty($_name)) ? $this->i18n('empty').' ' : ''), gettype($_name))
							);
						}
					unset($_name); // A little housekeeping.

					return (integer)$this->©db->query(
						"DELETE".
						" `".$this->©string->esc_sql($table)."`".

						" FROM".
						" `".$this->©string->esc_sql($this->©db_tables->get($table))."` AS `".$this->©string->esc_sql($table)."`".

						" WHERE".
						" `".$this->©string->esc_sql($table)."`.`".$this->©string->esc_sql((string)$rel_id_column)."` = '".$this->©string->esc_sql((string)$rel_id)."'".
						" AND `".$this->©string->esc_sql($table)."`.`name` IN(".$this->comma_quotify($names).")"
					);
				}

			/**
			 * Prepares comma-delimited, single-quoted values for an SQL query.
			 *
			 * @param array   $array An array of values (ONE dimension only here).
			 *
			 * @param boolean $convert_nulls_no_esc_wrap Optional. Defaults to a FALSE value.
			 *    By default, we convert all values into strings, and then we escape & wrap them w/ quotes.
			 *    However, if this is TRUE, NULL values are treated differently. We convert them to the string `NULL`,
			 *    and they are NOT quotified here. This should be enabled when/if NULL values are being inserted into a DB table.
			 *
			 * @return string A comma-delimited, single-quoted array of values, for an SQL query.
			 *
			 * @assert (array('hello', 'there')) === "'hello','there'"
			 */
			public function comma_quotify($array, $convert_nulls_no_esc_wrap = FALSE)
				{
					$this->check_arg_types('array', 'boolean', func_get_args());

					$array = $this->©strings->esc_sql_deep($array, $convert_nulls_no_esc_wrap);
					$array = $this->©strings->wrap_deep($array, "'", "'", TRUE, $convert_nulls_no_esc_wrap);

					return implode(',', $array);
				}

			/**
			 * Prepares comma-delimited, backticked values for an SQL query.
			 *
			 * @param array $array An array of values (ONE dimension only here).
			 *
			 * @return string A comma-delimited, backticked array of values, for an SQL query.
			 *
			 * @assert (array('hello', 'there')) === "`hello`,`there`"
			 */
			public function comma_tickify($array)
				{
					$this->check_arg_types('array', func_get_args());

					$array = $this->©strings->esc_sql_deep($array);
					$array = $this->©strings->wrap_deep($array, "`", "`");

					return implode(',', $array);
				}

			/**
			 * Prepares SQL file queries.
			 *
			 * @param string $sql_file Absolute server path to an SQL file.
			 *
			 * @return array An array containing SQL queries to execute, else an exception is thrown.
			 *    It's possible for this to return an empty array.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$sql_file`` is empty or invalid (i.e. NOT an SQL file).
			 * @throws exception If we fail to prepare queries.
			 *
			 * @assert ('foo.sql') throws exception
			 *
			 * @assert-failure-for-review $sql_file = dirname(dirname(dirname(__FILE__))).'/._dev-utilities/unit-test-files/prep.sql';
			 *    ($sql_file) === 'foo'
			 *
			 * @assert-failure-for-review $sql_file = dirname(dirname(dirname(__FILE__))).'/._dev-utilities/unit-test-files/empty.sql';
			 *    ($sql_file) === 'foo'
			 */
			public function prep_sql_file_queries($sql_file)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					if(preg_match('/\.sql$/', $sql_file) && is_file($sql_file))
						{
							$table_prefix  = $this->©db_table->prefix;
							$plugin_prefix = $this->___instance_config->plugin_prefix;
							$charset       = ($this->©db->charset) ? $this->©db->charset : 'utf8';
							$collate       = ($this->©db->collate) ? $this->©db->collate : 'utf8_unicode_ci';

							if(is_string($query = file_get_contents($sql_file)))
								{
									$replace = array(
										'/^SET\s+.+?;$/im',
										'/^\/\*\!.*?;$/im',
										'/ENGINE\s*\=\s*\w+/i',
										'/`'.preg_quote($plugin_prefix, '/').'/',
										'/DEFAULT\s+CHARSET\s*\=\s*\w+/i',
										'/DEFAULT\s+CHARACTER\s+SET\s*\=\s*\w+/i',
										'/DEFAULT\s+CHARACTER\s+SET\s+\w+/i',
										'/COLLATE\s*\=\s*\w+/i',
										'/COLLATE\s+\w+/i'
									);

									$with = array(
										'', // No SET statements.
										'', // No code-containing comments.
										'', // No engine specs (use default).
										'`'.$this->©string->esc_refs($table_prefix),
										'DEFAULT CHARSET='.$this->©string->esc_refs($charset),
										'DEFAULT CHARACTER SET='.$this->©string->esc_refs($charset),
										'DEFAULT CHARACTER SET '.$this->©string->esc_refs($charset),
										'COLLATE='.$this->©string->esc_refs($collate),
										'COLLATE '.$this->©string->esc_refs($collate)
									);

									if(is_string($query = preg_replace($replace, $with, $query)))
										{
											$queries = preg_split('/;$/m', $query, -1, PREG_SPLIT_NO_EMPTY);
											$queries = $this->©strings->trim_deep($queries);
											$queries = $this->©array->remove_0b_strings_deep($queries);

											return $queries;
										}
								}
						}
					throw $this->©exception(
						__METHOD__.'#preparation_failure', compact('sql_file'),
						sprintf($this->i18n('Unable to prepare queries from SQL file: `%1$s`.'), $sql_file)
					);
				}

			/**
			 * Forces integer/float values deeply (in DB result sets, if applicable).
			 *
			 * @see ``$this->©db_tables->regex_(integer|float)_columns``.
			 *
			 * @param mixed               $value Any value. Typically an array of results, where each result is an object or array with string keys.
			 *    Array/object keys MUST be strings, in order to match ``$this->©db_tables->regex_(integer|float)_columns``.
			 *    Integer keys are ignored completely.
			 *
			 * @param null|string|integer $key Used during recursion (this is primarily an internal argument value).
			 *    If any string key matches a regex pattern in ``$this->©db_tables->regex_(integer|float)_columns``;
			 *    AND, the existing associative value is numeric, this routine forces an (integer or float).
			 *
			 * @return mixed|array|object Mixed. Normally an array/object (i.e. a DB result set).
			 *
			 * @assert ('1') === '1'
			 * @assert (NULL) === NULL
			 * @assert (array('ID' => '1')) === array('ID' => 1)
			 * @assert (array('ID' => '1', 'related_id' => array('related_id' => '2'))) === array('ID' => 1, 'related_id' => array('related_id' => 2))
			 */
			public function typify_results_deep($value, $key = NULL)
				{
					$this->check_arg_types('', array('null', 'integer', 'string'), func_get_args());

					if(is_array($value) || is_object($value))
						{
							foreach($value as $_key => &$_value)
								$_value = $this->typify_results_deep($_value, $_key);
							unset($_key, $_value);

							return $value;
						}
					if(is_string($key) && is_numeric($value))
						{
							if($this->©string->in_regex_patterns($key, $this->©db_tables->regex_integer_columns)
							   && !$this->©string->in_regex_patterns($key, $this->©db_tables->regex_float_columns)
							   && !$this->©string->in_regex_patterns($key, $this->©db_tables->regex_string_columns)
							) return (integer)$value;

							if($this->©string->in_regex_patterns($key, $this->©db_tables->regex_float_columns)
							   && !$this->©string->in_regex_patterns($key, $this->©db_tables->regex_integer_columns)
							   && !$this->©string->in_regex_patterns($key, $this->©db_tables->regex_string_columns)
							) return (float)$value;
						}
					return $value; // Default return value.
				}

			/**
			 * Gets return value for `SQL_CALC_FOUND_ROWS/FOUND_ROWS()`.
			 *
			 * @param string $query Any valid MySQL SELECT query (in string format).
			 *    This routine forces the LIMIT to a value of `1`.
			 *
			 * @return integer Number of rows that would have been returned, had a LIMIT not been applied.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$query`` is NOT a `SELECT` statement.
			 *
			 * @assert ('SELECT DISTINCT `umeta_id` FROM `wp_usermeta` WHERE 1=1') > 0
			 */
			public function calc_found_rows($query)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$query = trim($query); // Trim the query up.

					if(!preg_match('/^SELECT\s+/i', $query))
						throw $this->©exception(
							__METHOD__.'#invalid_query', compact('query'),
							$this->i18n('Cannot get `FOUND_ROWS()` (missing `SELECT` statement).').
							sprintf($this->i18n(' This `$query` is NOT a `SELECT` statement: `%1$s`.'), $query)
						);
					$query = preg_replace('/^SELECT\s+/i', 'SELECT SQL_CALC_FOUND_ROWS ', $query);
					$query = preg_replace('/\s+LIMIT\s+[0-9\s,]*$/i', '', $query).' LIMIT 1';

					$this->©db->query($query);
					return (integer)$this->©db->get_var('SELECT FOUND_ROWS()');
				}

			/**
			 * Adds (or updates) a transient key/value (w/ database storage).
			 *
			 * @note This method should be used INSTEAD of using built-in WordPress® transient API calls.
			 *    The WordPress® transients API is subjected to object caching (which is NOT how we use transients).
			 *    In the eyes of the WordPress® Core, transients should always be stored in the database.
			 *
			 * @param string       $key The key/name for this transient value.
			 *
			 * @param mixed        $value Any value is fine (mixed data types are OK here).
			 *
			 * @param integer      $expires_after Optional. Time (in seconds) this transient should last for. Defaults to `-1` (no automatic expiration).
			 *    If this is set to anything <= `0`, the transient will NOT expire automatically (e.g. it remains until all transients are deleted from the DB).
			 *
			 * @return boolean TRUE if the transient value was set, else FALSE by default.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$key`` is empty (or if it's too long; producing a key which exceeds DB storage requirements).
			 */
			public function set_transient($key, $value, $expires_after = -1)
				{
					$this->check_arg_types('string:!empty', '', 'integer', func_get_args());

					$transient_prefix         = '_'.$this->___instance_config->plugin_prefix.'transient_';
					$transient_timeout_prefix = '_'.$this->___instance_config->plugin_prefix.'transient_timeout_';

					$transient         = $transient_prefix.md5($key);
					$transient_timeout = $transient_timeout_prefix.md5($key);

					$timeout  = ($expires_after > 0) ? time() + $expires_after : 0;
					$autoload = (!$timeout) ? 'yes' : 'no'; // Only if NO timeout value.

					if(get_option($transient) === FALSE) // It's new?
						{
							if($timeout) // This will timeout?
								add_option($transient_timeout, $timeout, '', 'no');

							return add_option($transient, $value, '', $autoload);
						}
					else // This transient already exists (let's update it).
						{
							if($timeout) // Update timeout value?
								update_option($transient_timeout, $timeout);

							return update_option($transient, $value);
						}
				}

			/**
			 * Gets a transient value (from the database).
			 *
			 * @note This method should be used INSTEAD of using built-in WordPress® transient API calls.
			 *    The WordPress® transients API is subjected to object caching (which is NOT how we use transients).
			 *    In the eyes of the WordPress® Core, transients should always be stored in the database.
			 *
			 * @param string $key The key/name for this transient value.
			 *
			 * @return mixed|boolean The transient value (if NOT expired yet), else FALSE by default.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$key`` is empty.
			 */
			public function get_transient($key)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$transient_prefix         = '_'.$this->___instance_config->plugin_prefix.'transient_';
					$transient_timeout_prefix = '_'.$this->___instance_config->plugin_prefix.'transient_timeout_';

					$transient         = $transient_prefix.md5($key);
					$transient_timeout = $transient_timeout_prefix.md5($key);

					if(!defined('WP_INSTALLING')) // WordPress® ``get_transient()`` does this.
						{
							$all_options = wp_load_alloptions(); // The `alloptions` cache.

							// If option is NOT in alloptions, it is NOT autoloaded, and thus has a timeout.
							if(!isset($all_options[$transient]) && (integer)get_option($transient_timeout) < time())
								{
									$this->delete_transient($key);

									return FALSE; // No longer exists (expired).
								}
						}
					return get_option($transient); // Default return value.
				}

			/**
			 * Deletes a transient value (from the database).
			 *
			 * @note This method should be used INSTEAD of using built-in WordPress® transient API calls.
			 *    The WordPress® transients API is subjected to object caching (which is NOT how we use transients).
			 *    In the eyes of the WordPress® Core, transients should always be stored in the database.
			 *
			 * @param string $key The key/name for this transient value.
			 *
			 * @return boolean TRUE if deletion was successful, else FALSE by default.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 * @throws exception If ``$key`` is empty.
			 */
			public function delete_transient($key)
				{
					$this->check_arg_types('string:!empty', func_get_args());

					$transient_prefix         = '_'.$this->___instance_config->plugin_prefix.'transient_';
					$transient_timeout_prefix = '_'.$this->___instance_config->plugin_prefix.'transient_timeout_';

					$transient         = $transient_prefix.md5($key);
					$transient_timeout = $transient_timeout_prefix.md5($key);

					if(($deleted = delete_option($transient)))
						delete_option($transient_timeout);

					return ($deleted) ? TRUE : FALSE;
				}

			/**
			 * Deletes expired transients from the database (for the current plugin).
			 *
			 * @return integer Number of rows deleted from the database.
			 *    Note that each transient has two rows (so this count might be off in some respects).
			 *
			 * @assert () is-type 'integer'
			 */
			public function cleanup_expired_transients()
				{
					$transient_prefix         = '_'.$this->___instance_config->plugin_prefix.'transient_';
					$transient_timeout_prefix = '_'.$this->___instance_config->plugin_prefix.'transient_timeout_';

					$query = // Cleanup expired transients (for the current plugin).

						"DELETE".
						" `transient`, `transient_timeout`".

						" FROM".
						" `".$this->©db_tables->get_wp('options')."` AS `transient`,".
						" `".$this->©db_tables->get_wp('options')."` AS `transient_timeout`".

						" WHERE".
						" `transient`.`option_name` LIKE '".$this->©string->esc_sql(like_escape($transient_prefix))."%'".
						" AND `transient`.`option_name` NOT LIKE '".$this->©string->esc_sql(like_escape($transient_timeout_prefix))."%'".

						" AND `transient_timeout`.`option_name` = CONCAT('".$this->©string->esc_sql($transient_timeout_prefix)."', SUBSTRING(`transient`.`option_name`, CHAR_LENGTH('".$this->©string->esc_sql($transient_prefix)."') + 1))".
						" AND `transient_timeout`.`option_value` < '".$this->©string->esc_sql((string)time())."'";

					$deletions = (integer)$this->©db->query($query);

					return $deletions; // Return total deletions.
				}

			/**
			 * Deletes transients from the database (for the current plugin).
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
			 *
			 * @return integer Number of rows deleted from the database.
			 *    Note that each transient has two rows (so this count might be off in some respects).
			 *
			 * @assert () is-type 'integer'
			 */
			public function delete_transients($confirmation)
				{
					$this->check_arg_types('boolean', func_get_args());

					$transient_prefix         = '_'.$this->___instance_config->plugin_prefix.'transient_';
					$transient_timeout_prefix = '_'.$this->___instance_config->plugin_prefix.'transient_timeout_';

					if($confirmation) // Do we have confirmation?
						{
							$query = // Purge all transients (for the current plugin).

								"DELETE".
								" `transients`".

								" FROM".
								" `".$this->©db_tables->get_wp('options')."` AS `transients`".

								" WHERE".
								" `transients`.`option_name` LIKE '".$this->©string->esc_sql(like_escape($transient_prefix))."%'".
								" OR `transients`.`option_name` LIKE '".$this->©string->esc_sql(like_escape($transient_timeout_prefix))."%'";

							return (integer)$this->©db->query($query);
						}
					return 0; // Default return value.
				}

			/**
			 * Deletes all CRON jobs associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen (i.e. nothing will be deleted).
			 *
			 * @return integer The number of CRON jobs that were deleted. Possibly `0`.
			 *    Check the CRONs class for further details on this return value.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @note Important... this is called upon by the ``deactivation_uninstall()`` method below.
			 */
			public function delete_cron_jobs($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if($confirmation) // Do we have confirmation?
						return $this->©crons->delete(TRUE, $this->cron_jobs);

					return 0; // Default return value.
				}

			/**
			 * Adds data/procedures associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns FALSE.
			 *
			 * @return boolean TRUE if successfully installed, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === FALSE
			 * @assert (TRUE) === TRUE
			 */
			public function activation_install($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if($confirmation) // Do we have confirmation?
						{
							$this->cleanup_expired_transients();
							$this->delete_cron_jobs(TRUE);

							return TRUE;
						}
					return FALSE; // Default return value.
				}

			/**
			 * Removes data/procedures associated with this class.
			 *
			 * @param boolean $confirmation Defaults to FALSE. Set this to TRUE as a confirmation.
			 *    If this is FALSE, nothing will happen; and this method returns FALSE.
			 *
			 * @return boolean TRUE if successfully uninstalled, else FALSE.
			 *
			 * @throws exception If invalid types are passed through arguments list.
			 *
			 * @assert () === FALSE
			 * @assert (TRUE) === TRUE
			 */
			public function deactivation_uninstall($confirmation = FALSE)
				{
					$this->check_arg_types('boolean', func_get_args());

					if($confirmation) // Do we have confirmation?
						{
							$this->delete_transients(TRUE);
							$this->delete_cron_jobs(TRUE);

							return TRUE;
						}
					return FALSE; // Default return value.
				}
		}
	}