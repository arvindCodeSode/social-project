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
require_once 'user/ip.php';
$activity=new text_activity();
$blogs=new blogs($activity);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php require_once 'link.php'; ?>
  <title>ViVinam: Admin Panel</title>
  <style type="text/css">
html,body{margin: 0;padding: 0;font-family: Relaway,Helvetica,Arial; background-color: #f1f1f1;}
  </style>
</head>
<body>
<div class="register-container">
  <div class="regis-row">
    <div class="regis-column regis-left">
        <div class="top-line">
        <h1>Admin Panel Login</h1>
        <hr />
        </div>
      <div class="r-cont">
        <div id="message" style="text-align: center;">
        <?php if(isset($_GET['mess'])){echo $_GET['mess'];}?>
         </div>
        <form action="admin/admin-login.php" id="admin-form" class="action-form" method="post"  autocomplete="on">
          <!-- <label for="email">Email id</label> --><span class="Err" id="emailErr">  </span>
          <div class="input-container">
            <i class="fas fa-user f-icon"></i><input type="text" name="email" id="email" placeholder="Email / Username /Mobile" class="input-field"  autocomplete="on" />
          </div>
          <input type="hidden" name="csrf" value="<?=$blogs->csrf_token(); ?>">
          <!-- <label for="password">Password</label> --><span class="Err" id="passwordErr">  </span>
          <div class="input-container">
            <i class="fas fa-lock f-icon"></i> <input class="input-field" type="password" name="password" id="password" placeholder="Password.."  autocomplete="on" class="input-field" />
          </div>
          <div class="input-submit">
          <input type="submit" name="login" class="reg-submit" id="reg-submit" value="Login"  autocomplete="on" />
          </div>
        </form>
      </div>
    </div>
    <div class="regis-column regis-right">
  <?php require_once 'r-left.php'; ?>
    </div>
  </div>
  <?php require_once 'footer.php'; ?>
</div>
<script type="text/javascript" src="public/js/compress.js"></script>
<script type="text/javascript" src="public/js/script.js"></script>
<!--script end-->
</body>
</html>
