<?php
global $wsc;

$timer = microtime(TRUE);

for($i = 0; $i < 100; $i++)
{
	$wsc->©strings;
	//$wsc->instance;
}
echo number_format(microtime(TRUE) - $timer, 5, '.', '');