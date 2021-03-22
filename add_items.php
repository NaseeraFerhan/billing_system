<?php 
session_start();
include('header.php');
include 'DbConnect.php';
$db = new DbConnect();
$db->checkLoggedIn();
$error = '';
if(!empty($_POST['itemName']) && !empty($_POST['itemPrice'])){
	if(is_numeric($_POST['itemPrice'])){
		$db->saveItem($_POST); 
    header("Location:items_list.php");	
	} else{
		$error = "price not valid";
	}
    
} 

?>
<title>Bills : Billing System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>



	<div class="container">		
	  <h2 class="title mt-5">Add Item</h2>
	  <?php 
                if($error){ ?>
                  <div class="alert alert-warning"><?php echo $error ; ?></div>
                <?php
                }
               ?>
	  <?php #include('menu.php');?>		

      <form method="post">	  
      <table id="data-table" class="table table-condensed table-striped">

        <tr>
        <td>Item Name:</td>
        <td>
        <input type="text" name="itemName" id="itemName" required>
        </td>
        </tr>
        
        <tr>
        <td>Price:</td>
        <td><input type="text" name="itemPrice" id="itemPrice" required></td>
        </tr>

        <!-- <tr>
        <td>Tax:</td>
        <td><input type="text" name="itemTax" id="itemTax" required></td>
        </tr>

        <tr>
        <td>Stock Available:</td>
        <td><input type="number" name="stock" id="stock" required></td> -->

        </table>

		<input type="submit" value="Save" class="btn btn-primary">
        </form>
</div>	
<?php include('footer.php');?>