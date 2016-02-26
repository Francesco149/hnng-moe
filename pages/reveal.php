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

if (!defined('hnngAllowInclude')) {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');
}

require_once hnngRoot . 'conf.php';
global $hnngConf;
?>

<h1>Reveal URLs</h1>
<p class="lead">
    Find out where a hnng.moe shortened link leads to before clicking on it.
</p>
<form role="form" action="<?php echo $hnngConf['siteroot']; ?>/reveallink" 
	method="post" enctype="multipart/form-data">
    <div class="form-group">
        <input class="form-control" type="text" name="hnngUrl" value="">
    </div>
    <div class="form-group">
        <input id="hnngSubmit" class="btn btn-lg btn-success" 
            type="submit" name="shorten" value="Moe&#126;">
    </div>
</form>
<p><sub>You can also add /r/ in front of a shortened url's id to reveal it, 
for example <?php echo $hnngConf['siteroot_short']; ?>/31 &#8594; <?php 
echo $hnngConf['siteroot_short']; ?>/r/31</sub></p>
