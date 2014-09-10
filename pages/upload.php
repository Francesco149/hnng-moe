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
require_once hnngRoot . 'conf.php';
global $hnngConf;
?>

<h1>Share Files</h1>
<p class="lead">
    Maximum file size: 25M
</p>
<form action="<?php echo $hnngConf['siteroot']; ?>/doupload" method="post"
    enctype="multipart/form-data">
    <div class="form-group">
        <input type="file" name="file" id="file" align="center">
    </div>
    <div class="form-group">
        <input id="hnngSubmit" class="btn btn-lg btn-success" 
            type="submit" name="shorten" value="Moe&#126;">
    </div>
</form>
<p><sub>You can also upload screenshots and files directly from your desktop 
by setting up <a target="_blank" href="http://getsharex.com/">ShareX</a> for hnng.moe. 
Check out the <a href="<?php echo $hnngConf['siteroot']; ?>/api">API</a> for the settings.</sub></p>