<?php
/*
    Copyright 2014-2016 Franc[e]sco (lolisamurai@waifu.club)
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

define('hnngAllowInclude', true);
define('hnngRoot', realpath(dirname( __FILE__ )) . '/');
require_once hnngRoot . 'debug.php';
require_once hnngRoot . 'dbmanager.php';
require_once hnngRoot . 'conf.php';
require_once hnngRoot . 'utils.php';

$_GET = hnngSanitizeArray($_GET);
if ($hnngConf['manteinance'] && (empty($_GET['devkey']) ||
    $_GET['devkey'] != $hnngConf['devkey'])) {

    die("The site is currently undergoing manteinance.");
}

$key = "";
if (!empty($_GET['key'])) {
    $key = $_GET['key'];
}

echo hnngDeleteUpload($key);
?>
