<?php 
session_start();
include('header.php');
include 'DbConnect.php';
$db = new DbConnect();
$db->checkLoggedIn();

if(isset($_POST['email']) && isset($_POST['password'])){
    $db->saveUser($_POST);
	header("Location:users_list.php");		
} else {
   // echo "Error";
}

?>
<title>Bills : Billing System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>



	<div class="container">		
	  <h2 class="title mt-5">Add Staff</h2>
	  <?php #include('menu.php');?>		

      <form method="post">	  
      <table id="data-table" class="table table-condensed table-striped">

        <tr>
        <td>First Name:</td>
        <td>
        <input type="text" name="fname" id="fname" required>
        </td>
        </tr>
        
        <tr>
        <td>Last Name:</td>
        <td><input type="text" name="lname" id="lname" required></td>
        </tr>

        <tr>
        <td>Email:</td>
        <td><input type="email" name="email" id="email" required></td>
        </tr>

        <tr>
        <td>Password:</td>
        <td><input type="password" name="password" id="password" required></td>
        </tr>

        <tr>
        <td>Mobile:</td>
        <td><input type="number" name="mobile" id="mobile" required></td>
        </tr>

        <tr>
        <td>Address:</td>
        <td><textarea name="address" id="address" required></textarea></td>
        </tr>


        </table>

		<input type="submit" value="Save" class="btn btn-primary">
        </form>
</div>	
<?php include('footer.php');?>