<?php
/*
    Copyright 2014 Franc[e]sco (lolisamurai@tfwno.gf)
    This file is part of hnng.moe.
    hnng.moe is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.
    hnng.moe is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with hnng.moe. If not, see <http://www.gnu.org/licenses/>.
*/

if (!defined('hnngRoot')) {
	define('hnngRoot', realpath(dirname( __FILE__ )) . '/');
}

if (!defined('hnngAllowInclude')) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');
}

require_once hnngRoot . 'conf.php';

function horishet($errno, $errstr, $errfile, $errline) {
	// this might throw warnings but it's ok we're just debugging and we 
	// gotta make sure that we display the warnings whatever mime type we tried
	// to set in headers
	header_remove('Content-type');
	header_remove('Content-Length');
	header_remove('Content-Disposition');
	header('Content-type: text/html');
	throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
if ($hnngConf['debug']) {
	set_error_handler("horishet");
}
?>
