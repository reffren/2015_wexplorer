<?php  
header_remove();
include("stuff/db.php");
include("includes/functions.php");
redirect_404();
$id=$_GET['id'];
$cat=$_GET['categ'];
if($id&&!$cat) {
    $dbc_time=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_query($dbc_time,"SET NAMES 'utf8'");
    $query_time="SELECT unix_timestamp(post_last_modified) as unix_date FROM posts WHERE post_file_name='$id'";
    $data_time=mysqli_query($dbc_time, $query_time);
	$row_time=mysqli_fetch_array($data_time);
    $last_modified_time=$row_time['unix_date'];
	  if(!$last_modified_time) {
header("HTTP/1.0 404 Not Found");
include("404.php");
       exit();
	  }
      if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time){
        exit;
      } else {
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_modified_time).' GMT');
        }
}
  else {
    if($cat) {
      $dbc_time=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      mysqli_query($dbc_time,"SET NAMES 'utf8'");
      $query_time="SELECT unix_timestamp(category_last_modified) as unix_date FROM posts INNER JOIN categories USING (category_ID) WHERE category_ID='$cat'";
      $data_time=mysqli_query($dbc_time, $query_time);
	  $row_time=mysqli_fetch_array($data_time);
      $last_modified_time=$row_time['unix_date'];
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time){
        exit;
    } else {
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_modified_time).' GMT');
      }
    }
  }
if($last_modified_time) {
  if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $last_modified_time){
  exit;
  } else {
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $last_modified_time).' GMT');
  }
}
?>
<!doctype html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <meta name="google-site-verification" content="WCB9-EIyifeHneJydz-RNbD9z6kDkv590zJBVS3Lv-o" />
<?php 
  if($id) { // or $_SERVER['id'];
    $dbc_title=mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    mysqli_query($dbc_title,"SET NAMES 'utf8'");
    $query_title="SELECT post_title, post_description, post_keywords FROM posts WHERE post_file_name='$id'";
    $data_title=mysqli_query($dbc_title, $query_title);
    $row_title=mysqli_fetch_array($data_title); 
	  if($row_title['post_title']) {
        echo '<title>'.$row_title['post_title'].'</title>
';
	  }
	  if($row_title['post_description']) {
        echo '<meta name="Description" content="'.$row_title['post_description'].'"/>
';
	  }
	  if($row_title['post_keywords']) {
        echo '<meta name="keywords" content="'.$row_title['post_keywords'].'"/>';
	  }
   }
  else {
    if($title) {
      echo '<title>'.$title.'</title>
';
	}
    if($description) {
      echo '<meta name="Description" content="'.$description.'"/>
';
	}
    if($keywords) {
      echo '<meta name="keywords" content="'.$keywords.'"/>';
	}
  } 
  ?>

  <link rel="stylesheet" href="http://wexplorer.ru/style.css" />
  <script src="http://wexplorer.ru/includes/scripts.js"></script>
  <link rel="icon" href="http://wexplorer.ru/images/favicon.ico" type="image/favicon" />
</head>
<body>
<?php include_once("includes/analyticstracking.php") ?>
