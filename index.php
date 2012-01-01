<?php
//include db connect and seassion start.
include 'includes/function.php';
?>
<!-- 
Title: Photo Tagging
Author: Neill Horsman
URL: http://www.neillh.com.au
Credits: jQuery, imgAreaSelect 
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>PHP, MySQL and jQuery Photo Tagging by Neill Horsman</title>

	<!-- A simple css reset from yahoo -->
	<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/reset/reset-min.css" />

  <!-- Styles for tagging  -->
	<link rel="stylesheet" href="css/style.css" type="text/css" media="screen" title="no title" charset="utf-8"/>
	
	<!-- Styles for the jquery plugin from http://odyniec.net/projects/imgareaselect/ not supported by neillh.com.au -->
	<link rel="stylesheet" type="text/css" href="css/imgareaselect-animated.css" /> 

  <!-- Include jquery via google apis -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>

  <!-- The jquery plugin from http://odyniec.net/projects/imgareaselect/ not supported by neillh.com.au -->
	<script type="text/javascript" src="js/jquery.imgareaselect.pack.js"></script>
	
	<!-- Phototagging Load js -->
	<script type="text/javascript" src="js/jquery.load.js"></script>

  <!-- Outputs all tag styles, in the head for validation purposes. -->
  <?php echo get_tags('styles'); ?>
</head>
<body>
  <div id="site">
    <?php
    //Start jquery popup error checking. (this can removed if needed.
    if( isset($_SESSION['ERRMSG_ARR']) && is_array($_SESSION['ERRMSG_ARR']) && count($_SESSION['ERRMSG_ARR']) >0 ) {
    	echo "<div id='error-box'><ul class='err'>";
    	foreach($_SESSION['ERRMSG_ARR'] as $msg) {
    		echo "<li>",$msg,"</li>"; 
    	}
    	echo "</ul><span class='closebtn'><a href='#' id='error-link'>close</a></span></div>";
    	unset($_SESSION['ERRMSG_ARR']);
    }
    //END jquery popup error checking.
    ?>

    <h1>Phototagging script by <a href="http://www.neillh.com.au" target="_blank">Neill Horsman</a></h1>
    <h2><a href="mailto:phototagging@neillh.com.au">tagging@neillh.com.au</a> for support</h2>

    <!-- Can do this much simplier in jquery now #TODO -->
    <div class="on-off">
      <div class="start-tagging">Click here to start tagging</div>
      <div class="finish-tagging hide">Click here to cancel tagging</div>
    </div>

    <div class="image">
      <div id="title_container" class="hide">
      	<form method="post" action="includes/function.php">
      		<!-- Grab the X/Y/Width/Height we dont need x2 & y2, but will capture them anyway -->
      		<fieldset>
        		<input type="hidden" name="x1" id="x1" value="<?php echo $x1; ?>" />
        		<input type="hidden" name="y1" id="y1" value="<?php echo $y1; ?>" />
        		<input type="hidden" name="x2" id="x2" value="<?php echo $x2; ?>" />
        		<input type="hidden" name="y2" id="y2" value="<?php echo $y2; ?>" />
        		<input type="hidden" name="w" id="w" value="<?php echo $w; ?>" />
        		<input type="hidden" name="h" id="h" value="<?php echo $h; ?>" />
        		<label for="title">Tag text</label><br />
        		<input type="text" id="comment" name="comment" size="30" value="" maxlength="55" /><br />
        		<input type="hidden" name="tag" value="true" />
        		<input type="submit" value="Submit" class="" />
          </fieldset>
      	</form>
      </div>
      <img src="images/image.jpg" border="0" id="imageid" alt="cat running" />

      <!-- The UL can be moved into the function if wanted -->
    	<ul class="map">
        <?php echo get_tags('map'); ?>
    	</ul>
    </div>

    <h2 class="tagtitles">In this photo:</h2>
    <!-- The UL can be moved into the function if wanted -->
    <ul id="titles">
      <?php echo get_tags('list'); ?>
    </ul>

  <!-- END -->




  <h2>Notes.</h2>
  
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <fieldset>
      <input type="hidden" name="cmd" value="_s-xclick">
      <input type="hidden" name="hosted_button_id" value="58X2GPSA5Q6TQ">
      <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
      <img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
    </fieldset>
  </form>
  <br />
  <p>Working in Firefox, Chrome, Safari, IE8</p>

  <p>Edit includes/function.php to add your own database connection details</p>

  <p><strong>Database.</strong><br />
  database information now found in README
  </p>

  <p>imgAreaSelect jQuery plugin - <a href="http://odyniec.net/projects/imgareaselect/usage.html">http://odyniec.net/projects/imgareaselect/usage.html</a></p>
  </div>
</body>
</html>