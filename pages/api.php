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
global $hnngConf;
$apiurl = $hnngConf['siteroot'] . '/shortapi.php';
$fapiurl = $hnngConf['siteroot'] . '/upload_d.php';
?>

<div class="smalltext-page text-left">
<h1>API</h1>
<p>The hnng.moe link shortening API is located at</p>
<pre><?php echo $apiurl; ?></pre>
<p>You will have to send a GET request with an url parameter such as:</p>
<pre><?php echo $apiurl; ?>?url=http://www.example.com</pre>
<p>&nbsp;</p>
<p>The hnng.moe file upload API is located at</p>
<pre><?php echo $fapiurl; ?></pre>
<p>You will have to send a POST request and the file form value must be named
"file".</p>
<p>The response will be formatted in JSON and will contain both the link to the
file and the deletion link.
If anything goes wrong, status will contain a description of the error.</p>
<pre>{
    "url":"http://hnng.moe/f/...",
    "deletelink":"http://www.hnng.moe/deleteupload.php?key=...",
    "status":"OK"
}</pre>
<p>&nbsp;</p>
<p>I made a webm video tutorial that explains how to set up ShareX for hnng.moe
&#8594; <a target="_blank" href="http://hnng.moe/f/k">here</a>.</p>
<p>You can get ShareX <a target="_blank" href="http://getsharex.com/">here</a>.
</p>
<p>&nbsp;</p>
<h2>ShareX settings:</h2>
<pre>{
       "Name": "hnng.moe (url shortener)",
       "RequestType": "GET",
       "RequestURL": "<?php echo $apiurl; ?>",
       "FileFormName": "",
       "Arguments": {
         "url": "$input$"
       },
       "ResponseType": "Text",
       "RegexList": [],
       "URL": "",
       "ThumbnailURL": "",
       "DeletionURL": ""
}</pre>
<pre>{
       "Name": "hnng.moe (file upload)",
       "RequestType": "POST",
       "RequestURL": "<?php echo $fapiurl; ?>",
       "FileFormName": "file",
       "Arguments": {},
       "ResponseType": "Text",
       "RegexList": [
         "\\\"url\\\":\\\"(.+?)\\\"",
         "\\\"deletelink\\\":\\\"(.+?)\\\""
       ],
       "URL": "$1,1$",
       "ThumbnailURL": "",
       "DeletionURL": "$2,1$"
}</pre>
<p>&nbsp;</p>
<h2>Tweetbot settings:</h2>
<p>Go to Settings &#8594; Account Settings &#8594; URL Shortening &#8594;
Custom and enter</p>
<pre><?php echo $apiurl; ?>?url=%@</pre>
</div>
