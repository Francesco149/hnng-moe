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
if (empty($_GET['devkey']) || $_GET['devkey'] != $hnngConf['devkey']) {
    die("Sorry only developers can use this!");
}

if (!isset($_GET['time'])) {
    echo json_encode(array());
    exit();
}

$time = $_GET['time'];

$lastid = "";
if (isset($_GET['lastid'])) {
    $lastid = $_GET['lastid'];
}

$time = date("Y-m-d\TH:i:s\Z", $time);
$st = $db->prepare("SELECT id, url, time, deletekey " .
    "FROM hnng_urls WHERE time >= :time AND id != :lastid " .
    "ORDER BY time ASC LIMIT 0 , 4");
$st->bindValue(':time', $time, PDO::PARAM_STR);
$st->bindValue(':lastid', $lastid, PDO::PARAM_STR);
$st->execute();
$rows = $st->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($rows);
?>
