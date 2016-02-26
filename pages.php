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

if (!defined('hnngAllowInclude')) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');
}

require_once hnngRoot . 'conf.php';
require_once hnngRoot . 'utils.php';

// sanitize GET
$_GET = hnngSanitizeArray($_GET);

// will be used to dynamically load the desired contents
$pagename = $hnngConf['default_page']; // fall back to home on empty page

if (!empty($_GET['act'])) { // meh, this is redundant but it fixes shitty warns
	$pagename = $_GET['act'];
}

if (empty($_GET['devkey']) || $_GET['devkey'] != $hnngConf['devkey']) {
	// not a dev
	if ($hnngConf['manteinance']) {
    	$pagename = $hnngConf['manteinance_page'];
	}
	else if ($hnngConf['comingsoon']) {
    	$pagename = $hnngConf['wip_page'];
	}
}

if (!array_key_exists($pagename, $hnngPages)) {
    $pagename = $hnngConf['404_page']; // 404
}

// -----------------------------------------------------------------------------

function hnngCurrentPage() {
    global $hnngPages, $pagename;
    include(hnngRoot . $hnngPages[$pagename]);
}

function hnngPageActive($page) {
    global $hnngConf, $pagename;
    switch ($page) {
        case $pagename:
            return true;
            
        case $hnngConf['manteinance_page']:
        case $hnngConf['wip_page']:
            return $page == $hnngConf['default_page'];
    }
    
    return false;
}

function hnngEchoPageLink($link, $text, $page) {
    $active = '';
    
    if (hnngPageActive($page)) {
        $active = ' class="active"';
    }
    
    echo '<li' . $active . '><a href="' . $link . '">' . $text . '</a></li>';
}
?>
