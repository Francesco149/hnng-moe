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
require_once hnngRoot . 'dbmanager.php';

if (!isset($_POST['hnngUrl'])) {
?>
<h1>Oreru&#126;</h1>
<p class="lead">No url provided.</p>
<p>
    <div class="hnng-img-container">
        <img class="dynamicsize-img" 
        	src="<?php echo $hnngConf['siteroot']; ?>/img/hnng.jpg">
    </div>
</p>
<p><small>If the issue persists, the server might be experiencing some issues.
</small></p>
<?php
}
else {
    $url = $_POST['hnngUrl'];
    $result = hnngShortenUrl($url);
    $shortened = $result['url'];
    $deleteurl = $result['deletelink'];
    
    if ($result['status'] != 'OK') {
?>
        <h1>Oreru&#126;</h1>
        <p class="lead"><?php echo $result['status']; ?></p>
        <p>
            <div class="hnng-img-container">
                <img class="dynamicsize-img" 
                	src="<?php echo $hnngConf['siteroot']; ?>/img/hnng.jpg">
            </div>
        </p>
        <p><small>If the issue persists, the server might be experiencing some 
        issues.</small></p>
<?php
    }

    else {
?>
        <h1>Dekita! Here's your URL!</h1>
        <form>
            <div class="form-group">
<?php
            echo '<input class="form-control" type="text" value="' . 
            	$shortened . '">';
?>
            </div>
        </form>
<?php
    }
}
?>
