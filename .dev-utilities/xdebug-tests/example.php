<?php
global $wsc;

$timer = microtime(TRUE);

for($i = 0; $i < 100; $i++)
{
	$wsc->©strings;
	//$wsc->___instance_config;
}
echo number_format(microtime(TRUE) - $timer, 5, '.', '');