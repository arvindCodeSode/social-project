<?php
ob_start();
session_start();
session_regenerate_id( true );
if(!isset($_SESSION['user_login']['id'])){
    header("Location:user/login");
}
function __autoload($class){
    require_once "classes/$class.php";
}
$activity=new text_activity();
$blogs=new blogs($activity);
$share=new share($activity);
//  $arr1=[];
//  $arr2=[];
// $last_id1=$blogs->get_last_post_id()+1;
// foreach ($blogs->show_total($last_id1)  as $keys => $values) {
//   // $arr_key=array_keys($values);
//   $arr1[]=$values['post_id'];
//   $arr2[]=$values['total'];

// }
// arsort($arr2);
// foreach ($arr2 as $key => $value) {
//   echo "<pre>";
//   print_r($value);
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ViVinam: Trends</title>
  <?php require_once 'link.php'; ?>
  <style type="text/css">
    .right-container{ position: sticky;top: 45px;}
    .left-container{position: sticky;top: 45px;}
    .m-top-cont{z-index: 1;}
  </style>
</head>
<body>
<!--topnav file-->
<?php 
require_once 'topnav.php'; ?>
 <!-- topnav file end-->
<?php ?>
<!--grid row start using of flex boxes-->
<div class="row">
<!--popular blogs container left-->
  <div class="side left">
<?php require_once 'left.php'; ?>
  </div>
  <!--left colum end-->
  <!--main middle container-->
  <div class="middle">
  <!--middle container start-->
    <div class="middle-container">
      <div class="m-top-cont" >
        <div class="m-search-cont">
        <form id="m-search-form" action="">
          <input type="text" placeholder="Search" name="m-search" id="m-search">               
        </form> 
          <div class="result-wrapper">
          </div> 
          <ul class="navbar"> 
            <li><a class="get-home"><i class="fas fa-home"></i><span class="noti-no home-noti"> </span></a></li>
            <li><a class="get-video"><i class="fas fa-video"></i> <span class="noti-no video-noti"> </span></a></li>
            <li><a href="<?= htmlspecialchars('friends') ?>"  class="get-friends"><i class="fas fa-users"></i><span class="noti-no friends-noti"> </span></a></li>
            <li><a class="get-not"><i class="fas fa-bell"></i>  <span class="noti-no notification-noti"></span></a></li>
            <li><a class="setting-open next"><i class="fas fa-cog"></i></a></li>
          </ul>         
        </div>
      </div>
      <!--this is trends column-->
      <div class="trends m-slides" id="trends">
        <hr />
        <h4>hello</h4>
        <h1>Sorry! this is in under process</h1>
      </div>
    <!--trends column end-->
    </div>
  <!--middle blog continer end-->
  </div>
  <!--main middle container end-->
  <!--Bloggers name container-->
  <div class="side right">
<?php require_once 'right.php'; ?>
  </div>
  <!--blogger container end-->
</div>
    <!-- end of grid using of flex boxes-->
 <!--footer file-->
  <?php 
 require_once 'footer.php'; ?>
 <!--end footer file-->
 <!--script start-->
<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
<script type="text/javascript" src="script.js"></script>
<!--script end-->
</body>
</html>