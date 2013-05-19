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
 */

if(ob_get_level()) // Cleans output buffers.
	while(ob_get_level()) ob_end_clean();

header('HTTP/1.0 200 OK');
header('Content-Type: application/x-javascript; charset=UTF-8');
header('Expires: '.gmdate('D, d M Y H:i:s', strtotime('+1 week')).' GMT');
header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: max-age=604800');
header('Pragma: public');

echo file_get_contents(dirname(dirname(__FILE__)).'/jquery/json.min.js');
echo file_get_contents(dirname(dirname(__FILE__)).'/jquery/cookie.min.js');
echo file_get_contents(dirname(dirname(__FILE__)).'/jquery/sprintf.min.js');
echo file_get_contents(dirname(dirname(__FILE__)).'/jquery/scrollTo.min.js');

echo file_get_contents(dirname(dirname(__FILE__)).'/jquery-ui/toggles.min.js');

echo file_get_contents(dirname(__FILE__).'/core.min.js');