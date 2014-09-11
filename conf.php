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

require_once hnngRoot . 'includecheck.php';

$hnngConf = array(
    // this is the devkey. it can be used to test pages through index.php?act=&devkey=xxxxx
    // while the website is under manteinance
    // yes, this is extremely ghetto and I'll eventually make an admin login thingy
    'devkey' => 'password', 
    
    'siteroot' => 'http://www.hnng.moe', 
    'siteroot_short' => 'http://hnng.moe', 
    
    // special flags
    'manteinance' => false, 
    'comingsoon' => false, 
    'nofollow' => false, 
    
    // mysql
    'db_user' => 'user', 
    'db_pass' => 'pass', 
    'db_name' => 'mydb', 
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
    
    // anti flood
    'shorten_requestspersec' => 5, 
    'upload_requestspersec' => 3
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
    'reveallink' => 'pages/reveallink.php'
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
    'reveallink'
);
?>