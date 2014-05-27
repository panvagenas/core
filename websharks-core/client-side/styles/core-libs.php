#!/usr/bin/env php
<?php
/**
 * WebSharks™ Core Styles (Compiler)
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 */

error_reporting(-1);
ini_set('display_errors', TRUE);

if(strcasecmp(PHP_SAPI, 'cli') !== 0)
	exit('CLI required to compile scripts.');

ob_start(); // Begin compilation.

echo file_get_contents('http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&subset=latin,latin-ext')."\n";
echo file_get_contents(dirname(__FILE__).'/resets.min.css')."\n";
echo file_get_contents(dirname(__FILE__).'/jquery-ui-core.min.css')."\n";
echo file_get_contents(dirname(__FILE__).'/jquery-ui-forms.min.css')."\n";
echo file_get_contents(dirname(__FILE__).'/core.min.css')."\n";

file_put_contents(dirname(__FILE__).'/core-libs.min.css', trim(ob_get_clean()));