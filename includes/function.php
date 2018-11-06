<?php
/*
Title: Photo Tagging
Author: Neill Horsman
URL: http://www.neillh.com.au
Credits: jQuery, imgAreaSelect
*/

//Start session (for error reporting, can be stripped out if needed)
session_start();

//Array to store validation errors
$errmsg_arr = array();

//Validation error flag
$errflag = false;

//Include database connection details
$db_server =  'host'; // DB Host
$db_user =    'username';    // Username
$db_pass =    'password'; // Password
$db_name =    'db_name'; // DB Name

/* Connects to database system */
function db_connect(){
	global $db_server;
	global $db_user;
	global $db_pass;
	global $db_name;
	return $dbcnx = mysqli_connect($db_server, $db_user, $db_pass, $db_name);
	//$dbsel = mysqli_select_db($db_name, $dbcnx) or die("Error reading from database table: " . mysql_error());
	return $dbcnx;
}

//Connect to mysql server
$con = db_connect();

//Set up an array to store details from database
$list_tags = array();

function get_results($con) {

  //Query the DB
  $qry = " SELECT id, title, x1, y1, x2, y2, width, height FROM phototags ";

  $results=mysqli_query($con, $qry) or die("Error retrieving records: " . mysqli_error($con));

  while ($row=mysqli_fetch_array($results)) {
    extract ($row);
    $name = str_replace(' ', '-', $title);
    $list_tags[] = array('id' => $id, 'title' => $title, 'name' => $name, 'x1' => $x1, 'y1' => $y1, 'width' => $width, 'height' => $height);
  }

  return $list_tags;
}

//Outputting the tag styles
function get_tags($con, $return_type = '') {
	$output = '';

  //get results from DB
  $tags = get_results($con);

  //Do we have a return type and is $tags an array like expected
  if ($return_type != '' && is_array($tags) && $tags != '') {

    if ($return_type == 'styles') {
      $output .= '<style type="text/css">';

      $tag_counter = 1;

      //Build output
      foreach ($tags as $tag) {
        $output .= '.map a.tag_'.$tag_counter.' { ';
        //$output .= 'border:1px solid #000;';
        //$output .= 'background:url(images/tag_hotspot_62x62.png) no-repeat;';
        $output .= 'top:'.$tag['y1'].'px;';
        $output .= 'left:'.$tag['x1'].'px;';
        $output .= 'width:'.$tag['width'].'px;';
        $output .= 'height:'.$tag['height'].'px;';
        $output .= 'border: 2px dashed red;';
        $output .= 'box-shadow: 0 0 3px rgba(0, 0, 0, 0.5);';
        //$output .= 'width:62px;';
        //$output .= 'height:62px;';
        $output .= '}';
        $tag_counter++;
      }

      $output .= '</style>';
    } else if ($return_type == 'map') {

      $tag_counter = 1;

      foreach ($tags as $tag) {
        $output .= '<li><a class="tag_'.$tag_counter.'" title="'.$tag['title'].'"><span><b>'.$tag['title'].'</b></span></a></li>';
        $tag_counter++;
      }

    } else if ($return_type == 'list') {

      $title_counter = 1;

      foreach ($tags as $tag) {
        $output .= '<li><a href="#" class="title" id="tag_'.$title_counter.'">'.$tag['title'].'</a> (<a href="includes/function.php?delete=true&amp;id='.$tag['id'].'">Delete</a>)</li>';
        $title_counter++;
      }
    }
	}

	return $output;
  $output = '';
}


//Function to sanitize values received from the form. Prevents SQL injection
function clean($con, $str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysqli_real_escape_string($con, $str);
}

if (!empty($_POST['tag'])) {
	//Sanitize the POST values
	$title = clean($con, $_POST['comment']);
	$x1 = clean($con, $_POST['x1']);
	$y1 = clean($con, $_POST['y1']);
	$w = clean($con, $_POST['w']);
	$h = clean($con, $_POST['h']);

	//Input Validations
	if($title == '') {
		$errmsg_arr[] = 'Tag title missing.';
		$errflag = true;
	}
	if($w == '' || $h == '' || $x1 == '' || $y1 == '') {
		$errmsg_arr[] = 'Area not selected';
		$errflag = true;
	}

	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: ../index.php");
		exit();
	}

	//Insert tag into database. I am capturing more data than needed from a previous version but this could be useful oneday.
	$qry = " INSERT INTO phototags (title, x1, y1, x2, y2, width, height) " .
	" VALUES('".$title."', '".$x1."', '".$y1."', '0', '0', '".$w."', '".$h."') ";
	if ($con->query($qry) === true) {
		$result = true;
	} else {
		print_r( mysqli_error($con) ); die;
	}

	//Check if query is ok
	if ($result) {
		header("location: ../index.php");
	} else {
		$errmsg_arr[] = 'Something went wrong.';
		$errflag = true;

		//If there are input validations, redirect back to the login form
		if ($errflag) {
			$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
			session_write_close();
			header("location: ../index.php");
			exit();
		}
	}
	exit();
} else if (!empty($_GET['delete'])) {
	//Sanitize the POST values
	$id = clean($con, $_GET['id']);
	$qry = " DELETE FROM phototags where id = $id ";
	$result=mysqli_query($con, $qry);
	header("location: ../index.php");
}

mysqli_close($con);

