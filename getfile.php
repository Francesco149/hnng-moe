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

$id = "";
if (!empty($_GET['fileid']) ||
    (isset($_GET['fileid']) && $_GET['fileid'] === '0')) {

    $id = $_GET['fileid'];
}

$fileinfo = hnngGetFileInfoById($id);

if (!isset($fileinfo)) {
    header('HTTP/1.0 404 Not Found', true, 404);
    $_GET['act'] = 'notfound';
    include(hnngRoot . 'index.php');
    exit();
}

$filepath = hnngRoot . '/' . $hnngConf['upload_dir'] . '/' . $id;
if ($fileinfo['mime_type'] === 'text/html' &&
    empty($_GET['execute_unsafe_html'])) {
?>

<html lang="en">
<body>
<head>
<link href="<?php echo $hnngConf['siteroot']; ?>/reset200802.css"
    rel="stylesheet">
<link href="<?php echo $hnngConf['siteroot']; ?>/moecode.css?t=<?php
    echo time(); ?>" rel="stylesheet">
</head>
<h1>HNNG.MOE - Warning!</h1>
<p>
You are trying to access a .html file. This can potentially execute malicious
code, so please check the code below and continue only if you trust this file.
</p>
<p>
&#8594; <a href="<?php echo $hnngConf['siteroot_short'] . '/f/' . $id .
'/execute_unsafe_html=1'; ?>">Yes, I trust this file.</a>
</p>
<code><?php
    $html = file_get_contents($filepath);
    echo htmlspecialchars($html);
?></code>
</body>

<?php
} else {
    header('Content-type: ' . $fileinfo['mime_type']);
    header('Content-Length: ' . filesize($filepath));
    header('Content-Disposition: filename="' .
        $fileinfo['original_name'] . '"');
    readfile($filepath);
}

?>
