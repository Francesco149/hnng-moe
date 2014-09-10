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
require_once hnngRoot . 'utils.php';

if($hnngConf['private_upload']) {
    $_POST = hnngSanitizeArray($_POST);
    
    if ($_POST['key'] != $hnngConf['private_upload_key']) {
        die("Sorry, the uploader is private at the moment!");
    }
}

$result = hnngUploadFile($_FILES['file']);
$res = $result['url'];
$deleteurl = $result['deletelink'];

if($result['status'] != 'OK') {
?>
    <h1>Oreru&#126;</h1>
    <p class="lead"><?php echo $res; ?></p>
    <p>
        <div class="hnng-img-container">
            <img class="dynamicsize-img" src="<?php echo $hnngConf['siteroot']; ?>/img/hnng.jpg">
        </div>
    </p>
    <p><small>If the issue persists, the server might be experiencing some issues.</small></p>
<?php
}

else {
?>
    <h1>Dekita! Here's your File!</h1>
    <form>
        <div class="form-group">
<?php
        echo '<input class="form-control" type="text" value="' . $res . '">';
?>
<p>&nbsp;</p>
            <p><sub>To delete your file, just save this link and visit it when you need to delete it:</sub></p>
<?php
            echo '<input class="form-control" type="text" value="' . $deleteurl . '">';
?>
        </div>
    </form>
<?php
}
?>