<?php 
	require_once('session.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<!-- StyleSheets -->
		
		<!-- GOOGLE FONTS -->
		<link href='https://fonts.googleapis.com/css?family=Roboto:900,700,500,400,300' rel='stylesheet' type='text/css'>
	
		<!-- JavaScripts -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="./assets/js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="./assets/js/jquery.timeago.js" type="text/javascript"></script>
		<script src="./assets/js/wordo.js" type="text/javascript"></script>
		<script src="./assets/js/mywl.js" type="text/javascript"></script>
		<script src="./assets/js/profile.js" type="text/javascript"></script>
		<script src="./assets/js/notifications.js" type="text/javascript"></script>
		
		
		<title>
    <?php 
			if (function_exists('wordo_get_meta_title')) {
				if (wordo_get_meta_title()) {
          echo wordo_get_meta_title();
        } else {
          echo 'Wordo';
        }  
			} else {
				echo 'Wordo';
			}
		?>
    </title>
		<meta name="description" 
    content=
    <?php 
			if (function_exists('wordo_get_meta_desc')) {
        if (wordo_get_meta_desc()) {
				  echo '"'.str_replace('"','',wordo_get_meta_desc()).'"';
        } else {
          echo '"Wordo is the clutter-free online dictionary. It\'s very easy to use."';          
        }
			} else {
				echo '"Wordo is the clutter-free online dictionary. It\'s very easy to use."';
			}
		?>
    >
		<link rel="shortcut icon" type="image/png" href="./assets/images/favicon.png">
		<link rel="shortcut icon" href="./assets/images/favicon.png">
		<link rel="image_src" href="./assets/images/logo.png" />
		<link rel="stylesheet" href="./assets/styles/style.css" type="text/css" />
		<link rel="stylesheet" href="./assets/styles/responsive.css" type="text/css" />
		<meta content=width=device-width,initial-scale=1 name=viewport />

		
		<!-- OSD SEARCH CODE -->
		<link rel="search" type="application/opensearchdescription+xml" title="MySite" href="/osd.xml" />
  
  <!-- Piwik -->
  <script type="text/javascript">
    var _paq = _paq || [];
    _paq.push(["setDomains", ["*.wordo.co"]]);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    (function() {
      var u="http://wordo.co/piwik/";
      _paq.push(['setTrackerUrl', u+'piwik.php']);
      _paq.push(['setSiteId', 1]);
      var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
      g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
    })();
  </script>
  <noscript><p><img src="http://wordo.co/piwik/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
  <!-- End Piwik Code -->

	</head>
	<body>	
	

		<?php require_once('nav.php'); ?>
		
	