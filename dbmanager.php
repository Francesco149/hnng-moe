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

$db = null;

global $hnngReserved;
global $hnngConf;
global $db;
global $charset;

$charset = str_split('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');

try {
    $db = new PDO('mysql:host=' . $hnngConf['db_host'] . ';dbname=' . 
        $hnngConf['db_name'] . ';charset=utf8', $hnngConf['db_user'], 
        $hnngConf['db_pass']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch (PDOException $ex) {
    die('Oreru! Database connection failed: ' . $ex->getMessage());
}
    
function hnngGetUrlById($id) {
    global $db;
    try {
        $st = $db->prepare("SELECT url FROM hnng_urls WHERE id=?");
        $st->bindValue(1, $id, PDO::PARAM_STR);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) != 1) {
            return null;
        }
        
        $url = $rows[0]['url'];
        
        if (empty($url)) {
            return null;
        }
            
        return $url;
    }
    
    catch (PDOException $ex) {
        return null;
    }
    
    return null;
}

function hnngGetFileInfoById($id) {
    global $db;
    try {
        $st = $db->prepare("SELECT * FROM hnng_uploads WHERE id=?");
        $st->bindValue(1, $id, PDO::PARAM_STR);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) != 1) {
            return null;
        }
        
        return $rows[0];
    }
    
    catch (PDOException $ex) {
        return null;
    }
    
    return null;
}

function hnngGetNextCombination($id) {
    global $charset, $hnngReserved;
    $charsetlen = count($charset);
    $splitid = str_split($id);
    $idindex = strlen($id) - 1;
    
    while (true) {
        $done = false;
        
        while (!$done) {
            $found = false;
            
            if ($idindex < 0) {
                array_unshift($splitid, $charset[0]); // WHY IS THIS CALLED UNSHIFT
                // COULDN'T THEY CALL IT INSERT OR SOMETHING
                $idindex = 0;
            }
            
            for ($i=0; $i<$charsetlen; $i++) {
                // find the next character in the charset
                if ($charset[$i] == $splitid[$idindex]) {
                    if ($i == $charsetlen - 1) { // carry to prev character
                        $splitid[$idindex] = $charset[0];
                        $idindex--;
                        $found = true;
                        break;
                    }
                    
                    else {
                        $splitid[$idindex] = $charset[$i + 1];
                        $found = true;
                        $done = true;
                        break;
                    }
                }
            } // for end
            
            if (!$found) { // character not in charset
                return null;
            }
        } // while !$done end
        
        if (!in_array(implode('', $splitid), $hnngReserved)) {
            break;
        }
    } // while true end
    
    return implode('', $splitid);
}

function hnngShortenUrl($url) {
    global $db, $hnngConf, $charset;
    
    if (strlen($url) > 2000) {
        $url = substr($url, 0, 2000);
    }
    
    // TODO: see if I can find a way to not provide a delete link when it's not 
    // possible (for example when re-shortening an url that has already been shortened)
    $outputarray = array(
        'url' => 'error', 
        'deletelink' => 'http://hnng.moe', 
        'status' => 'OK'
    );
    
    $reuse = false;
    
    if(!filter_var($url, FILTER_VALIDATE_URL)) {
        $outputarray['status'] = 'Your URL is invalid. Please try again.';
        return $outputarray;
    }
    
    $hash = md5($url);
    
    try {
        $st = $db->prepare("SELECT id FROM hnng_urls WHERE hash = ?");
        $st->bindValue(1, $hash, PDO::PARAM_STR);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($rows) > 0) { // url aready exists
            $outputarray['url'] = $hnngConf['siteroot_short'] . '/' . $rows[0]['id'];
            return $outputarray;
        }
        
        $st = $db->prepare("SELECT * FROM hnng_deleted_urls ORDER BY number ASC LIMIT 1");
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $id = '';
        $number = 0;
        
        if (!empty($rows)) { // reuse a deleted id
            $id = $rows[0]['id'];
            $number = $rows[0]['number'];
            $reuse = true;
        }
        else {
            $st = $db->prepare("SELECT id FROM hnng_urls ORDER BY number DESC LIMIT 1");
            $st->execute();
            $rows = $st->fetchAll(PDO::FETCH_ASSOC);
            $id = $charset[0];
            
            if (!empty($rows)) {
                $lastid = $rows[0]['id'];
                $id = hnngGetNextCombination($lastid);
            }
            
            if (!isset($id)) {
                $outputarray['status'] = 'Unknown id error, please report this to the developer.';
                return $outputarray;
            }
        }
        
        $deletekey = md5($id . $url . $ip . time() . $hash);
        
        $que = $reuse ? "INSERT INTO hnng_urls(id, url, ip, hash, deletekey, number) VALUES(:id, :url, :ip, :hash, :deletekey, :number)"
                :
                        "INSERT INTO hnng_urls(id, url, ip, hash, deletekey) VALUES(:id, :url, :ip, :hash, :deletekey)";
        
        $st = $db->prepare($que);
        $st->bindValue(':id', $id, PDO::PARAM_STR);
        $st->bindValue(':url', $url, PDO::PARAM_STR);
        $st->bindValue(':ip', $ip, PDO::PARAM_STR);
        $st->bindValue(':hash', $hash, PDO::PARAM_STR);
        $st->bindValue(':deletekey', $deletekey, PDO::PARAM_STR);
        
        if ($reuse) {
            $st->bindValue(':number', $number, PDO::PARAM_INT);
        }
        
        $st->execute();
        
        $outputarray['url'] = $hnngConf['siteroot_short'] . '/' . $id;
        $outputarray['deletelink'] = $hnngConf['siteroot'] . '/deletelink.php?key=' . $deletekey;
        
        if ($reuse) { // delete the id from the deleted id's table
            $st = $db->prepare("DELETE FROM hnng_deleted_urls WHERE id = :id");
            $st->bindValue(':id', $id);
            $st->execute();
        }
        
        return $outputarray;
    }
    
    catch (PDOException $ex) {
        $outputarray['status'] = 'There\'s a database error. Try again or report this to the developer.'; 
        // todo: log $ex->getMessage()
        return $outputarray;
    }
    
    $outputarray['status'] = 'Unknown error! Report this to the developer.';
    return $outputarray;   
}

function hnngUploadFile($file) {
    global $db, $hnngConf, $charset;
    
    $outputarray = array(
        'url' => 'error', 
        'deletelink' => 'http://hnng.moe', 
        'status' => 'OK'
    );
    
    try {
        $st = $db->prepare("SELECT * FROM hnng_deleted_uploads ORDER BY number ASC LIMIT 1");
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        $ip = $_SERVER['REMOTE_ADDR'];
        $id = '';
        $number = 0;
        $reuse = false;
        
        if (!empty($rows)) { // reuse a deleted id
            $id = $rows[0]['id'];
            $number = $rows[0]['number'];
            $reuse = true;
        }
        else {
            // get the last uploaded file id
            $st = $db->prepare("SELECT id FROM hnng_uploads ORDER BY number DESC LIMIT 1");
            $st->execute();
            $rows = $st->fetchAll(PDO::FETCH_ASSOC);
            $id = $charset[0];
            
            if (!empty($rows)) {
                $lastid = $rows[0]['id'];
                $id = hnngGetNextCombination($lastid);
            }
            
            if (!isset($id)) {
                $outputarray['status'] = 'Unknown id error, please report this to the developer.';
                return $outputarray;
            }
        }
    
        $originalname = basename($file['name']);
        $mime = $file['type'];
    
        // destination upload directory
        $dstpath = hnngRoot . '/' . $hnngConf['upload_dir'] . '/' . $id;
        
        if (!move_uploaded_file($file['tmp_name'], $dstpath)) {
            $outputarray['status'] = 'Upload error';
            return $outputarray;
        }
        
        $deletekey = md5($id . $mime . $originalname . $ip . time());
        
        $que = $reuse ? "INSERT INTO hnng_uploads(id, mime_type, original_name, ip, deletekey, number) " . 
                        "VALUES(:id, :mime_type, :original_name, :ip, :deletekey, :number)"
                :
                        "INSERT INTO hnng_uploads(id, mime_type, original_name, ip, deletekey) " . 
                        "VALUES(:id, :mime_type, :original_name, :ip, :deletekey)";
        
        $st = $db->prepare($que);
        $st->bindValue(':id', $id, PDO::PARAM_STR);
        $st->bindValue(':mime_type', $mime, PDO::PARAM_STR);
        $st->bindValue(':original_name', $originalname, PDO::PARAM_STR);
        $st->bindValue(':ip', $ip, PDO::PARAM_STR);
        $st->bindValue(':deletekey', $deletekey, PDO::PARAM_STR);
        
        if ($reuse) {
            $st->bindValue(':number', $number, PDO::PARAM_INT);
        }
        
        $st->execute();
        
        $outputarray['url'] = $hnngConf['siteroot_short'] . '/' . $hnngConf['upload_access'] . '/' . $id;
        $outputarray['deletelink'] = $hnngConf['siteroot'] . '/deleteupload.php?key=' . $deletekey;
        
        if ($reuse) { // delete the id from the deleted id's table
            $st = $db->prepare("DELETE FROM hnng_deleted_uploads WHERE id = :id");
            $st->bindValue(':id', $id);
            $st->execute();
        }
        
        return $outputarray;
    }
    
    catch (PDOException $ex) {
        $outputarray['status'] = 'There\'s a database error. Try again or report this to the developer.'; 
        // todo: log $ex->getMessage()
        return $outputarray;
    }
    
    $outputarray['status'] = 'Unknown error! Report this to the developer.';
    return $outputarray;   
}

function hnngDeleteUrl($key) {
    global $db;
    try {
        $st = $db->prepare("SELECT id, url, ip, hash, number FROM hnng_urls WHERE deletekey=?");
        $st->bindValue(1, $key, PDO::PARAM_STR);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($rows)) {
            return 'Your deletion link is invalid or has already been used.';
        }
        
        if (count($rows) != 1) {
            return 'Unexpected row count. Please report this to the developer.';
        }
        
        $id = $rows[0]['id'];
        $url = $rows[0]['url'];
        $ip = $rows[0]['ip'];
        $hash = $rows[0]['hash'];
        $number = $rows[0]['number'];
        $deletedbyip = $_SERVER['REMOTE_ADDR'];
        
        $st = $db->prepare("INSERT INTO hnng_deleted_urls(id, url, ip, hash, number, deletedbyip) " . 
            "VALUES(:id, :url, :ip, :hash, :number, :deletedbyip)");
        $st->bindValue(':id', $id, PDO::PARAM_STR);
        $st->bindValue(':url', $url, PDO::PARAM_STR);
        $st->bindValue(':ip', $ip, PDO::PARAM_STR);
        $st->bindValue(':hash', $hash, PDO::PARAM_STR);
        $st->bindValue(':number', $number, PDO::PARAM_INT);
        $st->bindValue(':deletedbyip', $deletedbyip, PDO::PARAM_STR);
        $st->execute();
        
        $st = $db->prepare("DELETE FROM hnng_urls WHERE deletekey=?");
        $st->bindValue(1, $key, PDO::PARAM_STR);
        $st->execute();
            
        return 'Success! Your URL has been deleted.';
    }
    
    catch (PDOException $ex) {
        return 'Database error. If the issue persists, the server might be experiencing some issues. ' . $ex->getMessage();
    }
    
    return 'Unexpected error. Please report this to the developer.';
}

function hnngDeleteUpload($key) {
    global $db;
    try {
        $st = $db->prepare("SELECT id, mime_type, original_name, ip, number FROM hnng_uploads WHERE deletekey=?");
        $st->bindValue(1, $key, PDO::PARAM_STR);
        $st->execute();
        $rows = $st->fetchAll(PDO::FETCH_ASSOC);
        
        if (empty($rows)) {
            return 'Your deletion link is invalid or has already been used.';
        }
        
        if (count($rows) != 1) {
            return 'Unexpected row count. Please report this to the developer.';
        }
        
        $id = $rows[0]['id'];
        $mime = $rows[0]['mime_type'];
        $originalname = $rows[0]['original_name'];
        $ip = $rows[0]['ip'];
        $number = $rows[0]['number'];
        $deletedbyip = $_SERVER['REMOTE_ADDR'];
        
        $st = $db->prepare("INSERT INTO hnng_deleted_uploads(id, mime_type, original_name, ip, number, deletedbyip) " . 
            "VALUES(:id, :mimetype, :originalname, :ip, :number, :deletedbyip)");
        $st->bindValue(':id', $id, PDO::PARAM_STR);
        $st->bindValue(':mimetype', $mime, PDO::PARAM_STR);
        $st->bindValue(':originalname', $originalname, PDO::PARAM_STR);
        $st->bindValue(':ip', $ip, PDO::PARAM_STR);
        $st->bindValue(':number', $number, PDO::PARAM_INT);
        $st->bindValue(':deletedbyip', $deletedbyip, PDO::PARAM_STR);
        $st->execute();
        
        $st = $db->prepare("DELETE FROM hnng_uploads WHERE deletekey=?");
        $st->bindValue(1, $key, PDO::PARAM_STR);
        $st->execute();
            
        return 'Success! Your file has been deleted.';
    }
    
    catch (PDOException $ex) {
        return 'Database error. If the issue persists, the server might be experiencing some issues.';
    }
    
    return 'Unexpected error. Please report this to the developer.';
}
?>