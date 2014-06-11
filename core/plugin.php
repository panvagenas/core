<?php
/*                                                                                      a
                                                                                       aaa
                                                                                      aaaaa
                                                              hhhh        hhhh       aaa aaa        rrrrrrrr
                                                  sssssss     hhhh        hhhh      aaaa aaaa      rrrrrrrrrrr    kkkk
www        w        ww eeeeeeeee  bbbbbbbb      sssssssssss   hhhh        hhhh     aaaa   aaaa     rrrr   rrrrr   kkkk     kkk      ssss
 www      www      www eeeeeeeee  bbbbbbbbb    sssss    sss   hhhh        hhhh    aaaaa   aaaaa    rrrr   rrrrr   kkkk   kkkkk   sssssssss
  www    wwwww    www  eee        bbb   bbb     sssss         hhhhhhhhhhhhhhhh   aaaaa     aaaaa   rrrrrrrrrr     kkkk  kkkk     ssss  sss
   www  www www  www   eeeeeeeee  bbbbbbbb       ssssssss     hhhhhhhhhhhhhhhh  aaaaaaaaaaaaaaaaa  rrrrrrrr       kkkkkkkkk      sssss
    www ww   ww www    eeeeeeeee  bbbbbbbbbb        sssssss   hhhh        hhhh aaaaaaaaaaaaaaaaaaa rrrrrrrrr      kkkkkkkk        ssssssss
     wwww     wwww     eee        bbb    bbb            ssss  hhhh        hhhh aaaaa         aaaaa rrrr  rrrr     kkkk kkkkk          sssss
      ww       ww      eeeeeeeee  bbbbbbbbbb   ssss     ssss  hhhh        hhhh aaaa           aaaa rrrr   rrrrr   kkkk  kkkkk   sss     sss
      ww       ww      eeeeeeeee  bbbbbbbb     sssssssssssss  hhhh        hhhh aaa             aaa rrrr    rrrrr  kkkk    kkkkk sssssssssss
                                                 ssssssss     hhhh        hhhh aa               aa rrrr      rrrr kkkk     kkkk   sssssss
     wswswswswswswswswswswswswswswswswsws                                                                                               ®*/

/**
 * WebSharks™ Core (WP plugin).
 *
 * Copyright: © 2012 (coded in the USA)
 * {@link http://www.websharks-inc.com WebSharks™}
 *
 * @author JasWSInc
 * @package WebSharks\Core
 * @since 130310
 */
/* -- WordPress® --------------------------------------------------------------------------------------------------------------------------

Version: 000000-dev
Stable tag: 000000-dev
Tested up to: 3.9.1
Requires at least: 3.5.1

Requires at least Apache version: 2.1
Tested up to Apache version: 2.4.7

Requires at least PHP version: 5.3.1
Tested up to PHP version: 5.5.12

Copyright: © 2012 WebSharks, Inc.
License: GNU General Public License
Contributors: WebSharks

Author: WebSharks, Inc.
Author URI: http://www.websharks-inc.com

Text Domain: wsc
Domain Path: /translations

Plugin Name: WebSharks™ Core
Plugin URI: http://github.com/WebSharks/Core

Description: WebSharks™ Core framework for WordPress® plugin development.
Tags: websharks, websharks core, framework, plugin framework, development, developers

-- end section for WordPress®. --------------------------------------------------------------------------------------------------------- */

if(!defined('WPINC'))
	exit('Do NOT access this file directly: '.basename(__FILE__));

/*
 * Load dependency utilities.
 */
$GLOBALS['autoload_wsc_v000000_dev'] = FALSE;
require_once dirname(__FILE__).'/stub.php';
require_once wsc_v000000_dev::deps();

/*
 * Check dependencies (and load framework; if possible).
 */
if(deps_wsc_v000000_dev::check(wsc_v000000_dev::$core_name, dirname(__FILE__)) === TRUE)
	require_once wsc_v000000_dev::framework();