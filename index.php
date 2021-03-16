<?php 
session_start();
include('header.php');
$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	include 'DbConnect.php';
	$db = new DbConnect();
	$user = $db->loginUsers($_POST['email'], $_POST['pwd']); 
	if(!empty($user)) {
		$_SESSION['user'] = $user[0]['first_name']."".$user[0]['last_name'];
		$_SESSION['userid'] = $user[0]['id'];
		$_SESSION['email'] = $user[0]['email'];		
		$_SESSION['address'] = $user[0]['address'];
		$_SESSION['mobile'] = $user[0]['mobile'];
		$_SESSION['isAdmin'] = $user[0]['isAdmin'];
		header("Location:bill_list.php");
	} else {
		$loginError = "Invalid email or password!";
	}
}

if (isset($_SESSION['userid'])){
	header("Location:bill_list.php");
}

?>
<title>Login | Billing System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<style type="text/css">
	.form-control {
    height: 46px;
    border-radius: 46px;
    border: none;
    padding-left: 1.5rem;
    padding-right: 1.5rem;
    margin-top: 1.5rem;
    background: rgb(67, 34, 167);
}
</style>
<div class="row" style="background-image: url(img/bg.jpg);">	
	<div class="demo-heading">
		<h2 class="text-white">Login</h2>
	</div>
	<div class="login-form">		
		<h4>Billing User Login:</h4>		
		<form method="post" action="">
			<div class="form-group">
			<?php if ($loginError ) { ?>
				<div class="alert alert-warning"><?php echo $loginError; ?></div>
			<?php } ?>
			</div>
			<div class="form-group">
				<input name="email" id="email" type="email" class="form-control" placeholder="Email address"  required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="pwd" placeholder="Password"  required>
			</div>  
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-info">Login</button>
			</div>
		</form>
		<br>
		 <p><b>Email</b> : admin@gmail.com<br><b>Password</b> : admin</p>		
	</div>		
</div>		
</div>
<?php include('footer.php');?>