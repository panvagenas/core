<?php
/**
 * WebSharks™ Core Scripts.
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
header('Content-Type: application/x-javascript; charset=UTF-8');
header('Expires: '.gmdate('D, d M Y H:i:s', strtotime('+1 week')).' GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: max-age=604800');
header('Pragma: public');

echo file_get_contents(dirname(dirname(__FILE__)).'/jquery/scrollTo.min.js');
echo file_get_contents(dirname(dirname(__FILE__)).'/jquery-ui/toggles.min.js');
echo file_get_contents(dirname(__FILE__).'/core.min.js');