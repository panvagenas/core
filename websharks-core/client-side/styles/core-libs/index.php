<?php
/**
 * WebSharks™ Core Styles.
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 120318
 *
 * @TODO Make this static if possible.
 */

$_ob_levels = ob_get_level(); // Cleans output buffers.
for($_ob_level = 0; $_ob_level < $_ob_levels; $_ob_level++)
	ob_end_clean(); // May fail on a locked buffer.
unset($_ob_levels, $_ob_level);

header('HTTP/1.0 200 OK');
header('Content-Type: text/css; charset=UTF-8');
header('Expires: '.gmdate('D, d M Y H:i:s', strtotime('+1 week')).' GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: max-age=604800');
header('Pragma: public');

echo "@import url('//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700&subset=latin,latin-ext');";

echo file_get_contents(dirname(__FILE__).'/resets.min.css');
echo file_get_contents(dirname(dirname(__FILE__)).'/jquery-ui/core.min.css');
echo file_get_contents(dirname(dirname(__FILE__)).'/jquery-ui/forms.min.css');
echo file_get_contents(dirname(__FILE__).'/core.min.css');