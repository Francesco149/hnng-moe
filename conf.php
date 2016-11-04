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

$hnngConf = array(
    // this is the devkey. it can be used to
    // test pages through index.php?act=&devkey=xxxxx
    // while the website is under manteinance
    // yes, this is extremely ghetto and I'll eventually
    // make an admin login thingy
    'devkey' => 'password',

    'siteroot' => 'http://localhost',
    'siteroot_short' => 'http://localhost',

    // special flags
    'manteinance' => false,
    'comingsoon' => false,
    'nofollow' => false,
    'reuse_deleted_urls' => false,

    'enable_shortener' => false,
    'enable_upload' => true,

    // mysql
    'db_user' => 'root', // change these to your MySQL info
    'db_pass' => 'topmeme',
    'db_name' => 'omanko',
    'db_host' => 'localhost',

    // default pages
    'default_page' => 'home',
    'manteinance_page' => 'manteinance',
    'wip_page' => 'wip',
    '404_page' => 'notfound',

    // uploader stuff
    'upload_dir' => 'u',
    'upload_access' => 'f',
    'private_upload' => false,
    'private_upload_key' => 'password',

    // anti flood (per-ip)
    'shorten_requestspersec' => 3,
    'upload_requestspersec' => 3,

    // anti flood cooldown for users that exceed the requests per sec limit
    'shorten_cooldown' => 5,
    'upload_cooldown' => 5,

    // global rate limiter: if more than a certain amount of requests is sent
    // within a certain amount of time, a global cooldown will be triggered
    // and anyone trying to upload or shorten urls will see a heavy load error
    // message.
    // this is a measure to prevent people flooding the site with a huge list of
    // proxies from wasting too much database or disk space before you notice
    // and ban them.

    'shorten_global_request_limit' => 20,
    'shorten_global_request_time' => 7, // seconds
    'shorten_global_request_cooldown' => 60, // seconds

    'upload_global_request_limit' => 10,
    'upload_global_request_time' => 7,
    'upload_global_request_cooldown' => 60,

    'debug' => false
);

$hnngPages = array(
    'home' => 'pages/home.php',
    'api' => 'pages/api.php',
    'about' => 'pages/about.php',
    'donate' => 'pages/donate.php',
    'sharefiles' => 'pages/upload.php',

    // default pages
    'manteinance' => 'pages/manteinance.php',
    'wip' => 'pages/wip.php',
    'notfound' => 'pages/notfound.php',
    'createlink' => 'pages/createlink.php',
    'doupload' => 'pages/bupload.php',
    'reveal' => 'pages/reveal.php',
    'reveallink' => 'pages/reveallink.php',
    'privacy' => 'pages/privacy.php'
);

$hnngReserved = array(
    'do',
    'home',
    'api',
    'about',
    'donate',
    'manteinance',
    'wip',
    'notfound',
    'css',
    'fonts',
    'img',
    'js',
    'less',
    'pages',
    'scss',
    'u',
    'f',
    'r',
    'sharefiles',
    'doupload',
    'reveal',
    'reveallink',
    'privacy'
);
?>
