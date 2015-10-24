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
    $result = hnngRevealUrl($url);
    
    if (!filter_var($result, FILTER_VALIDATE_URL)) {
?>
        <h1>Oreru&#126;</h1>
        <p class="lead"><?php echo $result; ?></p>
        <p>
            <div class="hnng-img-container">
                <img class="dynamicsize-img" src="<?php 
                	echo $hnngConf['siteroot']; ?>/img/hnng.jpg">
            </div>
        </p>
        <p><small>If the issue persists, the server might be experiencing some 
        issues.</small></p>
<?php
    }

    else {
?>
        <p><h1>Dekita! Your URL points to:</h1></p>
        <form>
            <div class="form-group">
<?php
            echo '<input class="form-control" type="text" value="' . 
            	$result . '">';
?>
            </div>
        </form>
<?php
    }
}
?>
