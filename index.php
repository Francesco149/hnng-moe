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
	define('hnngAllowInclude', true);
}

if (!defined('hnngRoot')) {
	define('hnngRoot', realpath(dirname( __FILE__ )) . '/');
}

require_once hnngRoot . 'debug.php';
require_once hnngRoot . 'conf.php';
require_once hnngRoot . 'pages.php';
require_once hnngRoot . 'utils.php';

// only displaying this for IE users prevents markup validation errors
if (isset($_SERVER['HTTP_USER_AGENT']) && 
    (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
    header('X-UA-Compatible: IE=edge'); 
    // <meta http-equiv="X-UA-Compatible" content="IE=edge">
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" 
			content="File sharing and URL shortener for weebs.">
        <?php hnngEchoRobots(); ?>
        
        <!--                  [Welcome to hnng.moe v2.0!]                    -->
        <!-- Because cute girls doing cute things are serious business       -->
        <!-- Now javascript-free! J U C K F A V A S C R I P T                -->
        
        <title>HNNG.MOE URL Shortener & File Sharing</title>

		<link href="<?php echo $hnngConf['siteroot']; ?>/reset200802.css" 
			rel="stylesheet">
        <link href="<?php echo $hnngConf['siteroot']; ?>/style.css?t=<?php 
        	echo time(); ?>" rel="stylesheet">
        <link rel="shortcut icon" href="favicon.ico?t=<?php echo time(); ?>" 
        	type="image/x-icon">
        
        <meta property="og:title" content="HNNG.MOE URL Shortener">
        <meta property="og:description" 
        	content="URL shortening and file sharing for weebs.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $hnngConf['siteroot']; ?>">
        <meta property="og:image" 
        	content="<?php echo $hnngConf['siteroot']; ?>/img/rikka.png">
        <meta property="og:site_name" content="hnng.moe Link Shortener">
    </head>
    
    <!-- how do I quickscope -->
    
    <body>
        <!-- fixed header -->
		<ul class="nav">
		<li><a class="navbar-brand" href="<?php echo $hnngConf['siteroot']; ?>">
			HNNG.MOE URL Shortener</a></li>
		<?php 
			$sr = $hnngConf['siteroot'];
			
			$pagelinks = array(
				array($sr, 				   'Home', 	      'home'),
				array($sr . '/sharefiles', 'Share Files', 'sharefiles'),
				array($sr . '/reveal',     'Reveal URLs', 'reveal'),
				array($sr . '/api',        'API',         'api'),
				array($sr . '/about',      'About',       'about'),
				array($sr . '/donate',     'Donate',	  'donate'),
				array($sr . '/privacy',    'Privacy',     'privacy')
			);
			
			foreach ($pagelinks as $link) {
				hnngEchoPageLink($link[0], $link[1], $link[2]);
			}
		?>
		</ul>

        <!-- contents -->
		<div class="container">

            <div class="jumbotron">
                <?php
	                hnngCurrentPage();
				?>
	   		    <h6>
					Created by Franc[e]sco 
					<a href="https://twitter.com/roriicon">@roriicon</a>
				</h6>
            </div>
            
            <div class="footer jumbotron">
                <h6>
                    If the above boxes are completely opaque or completely 
                    transparent, I highly recommend that you upgrade to a 
                    more up-to-date browser, such as 
                    <a href="https://www.mozilla.org/en-US/firefox/all/">
						Firefox</a>.
				</h6>
			</div>

		</div>

	</body>
</html>
