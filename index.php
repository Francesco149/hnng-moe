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

define('hnngAllowInclude', true);
define('hnngRoot', realpath(dirname( __FILE__ )) . '/');
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
        <meta name="description" content="File sharing for moe anime lovers">
        <?php hnngEchoRobots(); ?>
        
        <!--                  [Welcome to hnng.moe v1.2b!]                   -->
        <!-- Because cute girls doing cute things are serious business       -->
        <!-- * this is my first time messing with bootstrap, so bear with my -->
        <!--   crappy web design skills ;_;                                  -->
        
        <title>HNNG, Moe&#126; URL Shortener & File Sharing</title>
        
        <link href="<?php echo $hnngConf['siteroot']; ?>/css/bootstrap.min.css" 
        	rel="stylesheet">
        <link 
        	href="<?php echo $hnngConf['siteroot']; ?>/css/font-awesome.min.css" 
        	rel="stylesheet">
        <link href="<?php echo $hnngConf['siteroot']; ?>/style.css?t=<?php 
        	echo time(); ?>" rel="stylesheet">
        <link 
        	href="<?php echo $hnngConf['siteroot']; ?>/css/bootstrap-social.css" 
        	rel="stylesheet">
        <link rel="shortcut icon" href="favicon.ico?t=<?php echo time(); ?>" 
        	type="image/x-icon">
        
        <!-- why would you even use IE you pleb -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js">
          </script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><
          /script>
        <![endif]-->
        
        <meta property="og:title" content="HNNG, Moe~ Link Shortener">
        <meta property="og:description" 
        	content="URL shortening and file sharing for moe lovers">
        <meta property="og:type" content="website">
        <meta property="og:url" content="<?php echo $hnngConf['siteroot']; ?>">
        <meta property="og:image" 
        	content="<?php echo $hnngConf['siteroot']; ?>/img/rikka.png">
        <meta property="og:site_name" content="HNNG, Moe~ Link Shortener">
    </head>
    
    <!-- how do I quickscope -->
    
    <body>
        <!-- facebook sdk -->
        <script>
          window.fbAsyncInit = function() {
            FB.init({
              appId      : '1463602017260949',
              xfbml      : true,
              version    : 'v2.0'
            });
          };
        
          (function(d, s, id){
             var js, fjs = d.getElementsByTagName(s)[0];
             if (d.getElementById(id)) {return;}
             js = d.createElement(s); js.id = id;
             js.src = "//connect.facebook.net/en_US/sdk.js";
             fjs.parentNode.insertBefore(js, fjs);
           }(document, 'script', 'facebook-jssdk'));
        </script>
    
        <!-- fixed header -->
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <!-- collapsed navbar menu (for mobile and stuff) -->
                <button type="button" class="navbar-toggle collapsed" 
                    data-toggle="collapse" data-target="#hnng-nav-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    
                    <!-- this is the collapsed navbar three-line icon thingy -->
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" 
                	href="<?php echo $hnngConf['siteroot']; ?>">
                	HNNG, Moe&#126; Link Shortener</a>
            </div>
            
            <!-- navbar menu -->
            <div class="collapse navbar-collapse" id="hnng-nav-collapse">
                <ul class="nav navbar-nav">
                <?php 
                	$donatetxt = 'Donate <i class="fa fa-heart"></i>';
                	$sr = $hnngConf['siteroot'];
                	
                	$pagelinks = array(
                		array($sr, 				   'Home', 	      'home'),
                		array($sr . '/sharefiles', 'Share Files', 'sharefiles'),
                		array($sr . '/reveal',     'Reveal URLs', 'reveal'),
                		array($sr . '/api',        'API',         'api'),
                		array($sr . '/about',      'About',       'about'),
                		array($sr . '/donate',     $donatetxt,    'donate'),
                		array($sr . '/privacy',    'Privacy',     'privacy')
                	);
                	
                	foreach ($pagelinks as $link) {
						hnngEchoPageLink($link[0], $link[1], $link[2]);
					}
                ?>
                </ul>
            </div>
        </div>
    
        <!-- contents -->
        <div class="container">
            <div class="jumbotron">
                <?php
                hnngCurrentPage();
                ?>
            </div>
            
            <div class="social jumbotron">
            <!-- social buttons begin -->
            <p>
                <a class="btn btn-social-icon btn-twitter"
                    target="_blank" href="https://twitter.com/share?url=<?php 
                    echo urlencode($hnngConf['siteroot']); ?>&amp;text=<?php 
                    echo urlencode('hnng.moe, url shortening and file ' . 
                    	'sharing for moe lovers'); 
                    ?>&amp;via=roriicon&amp;hashtags=moedomain"
                >
                  <i class="fa fa-twitter"></i>
                </a>
                <a class="btn btn-social-icon btn-facebook"
                    onclick="FB.ui({method: 'share', href: '<?php 
                    echo $hnngConf['siteroot']; 
                    ?>'}, function(response){});return false;"
                >
                  <i class="fa fa-facebook"></i>
                </a>
                <a class="btn btn-social-icon btn-google-plus"
                    href="https://plus.google.com/share?url=<?php 
                    echo urlencode($hnngConf['siteroot']); ?>" 
                    onclick="javascript:window.open(this.href, '', 
		                'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,' + 
		                'height=600,width=600');return false;"
                >
                  <i class="fa fa-google-plus"></i>
                </a>
                <a class="btn btn-social-icon btn-reddit" 
                    href="//www.reddit.com/submit" 
                    onclick="window.location = '//www.reddit.com/submit?url=' + 
                    	encodeURIComponent(window.location); return false"
                >
                  <i class="fa fa-reddit"></i>
                </a>
                <a class="btn btn-social-icon btn-tumblr"
                    target="_blank" 
                    href="http://www.tumblr.com/share?v=3&amp;u=<?php 
                    echo urlencode($hnngConf['siteroot']) . 
                    	'&amp;t=HNNG,%20Moe&#126;%20Link%20Shortener"';
                   ?>
                >
                  <i class="fa fa-tumblr"></i>
                </a>
            </p>
            <!-- social buttons end -->
            
            <h6>
            	Created by Franc[e]sco 
            	<a href="https://twitter.com/roriicon">@roriicon</a>
            </h6>
            </div>
            
            <div class="footer jumbotron">
                <h6>
                    If the above boxes are completely opaque or completely 
                    transparent, I highly recommend that you upgrade to a 
                    better and up-to-date browser, such as 
                    <a href="https://www.mozilla.org/en-US/firefox/all/">
                    	Firefox</a>.
                </h6>
            </div>
        </div>
        
        <!-- bootstrap and jquery -->
        <script 
        src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js">
        </script>
        <script src="<?php echo $hnngConf['siteroot']; ?>/js/bootstrap.min.js">
        	</script>
    </body>
</html>
