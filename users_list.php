<?php 
session_start();
include('header.php');
include 'DbConnect.php';
$db = new DbConnect();
$db->checkLoggedIn();
?>
<title>Bills : Billing System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>


	<div class="container">		
	  <h2 class="title mt-5">Staffs</h2>
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Admin</th>
          </tr>
        </thead>
        <?php		
	    	$usersList = $db->getUsers();
        foreach($usersList as $user){


      echo '
              <tr>
                <td>'.$user["first_name"].' '.$user["last_name"].'</td>
                <td>'.$user["email"].'</td>
                <td>'.$user["mobile"].'</td>';
                echo '<td>'; if ($user["isAdmin"]) echo 'Yes'; else echo 'No';echo '</td>';
            echo    '</tr>
            ';

            // echo '
            //   <tr>
            //     <td>'.$invoiceDetails["order_id"].'</td>
            //     <td>'.$invoiceDate.'</td>
            //     <td>'.$invoiceDetails["order_receiver_name"].'</td>
            //     <td>'.$invoiceDetails["order_total_after_tax"].'</td>
            //     <td><a href="print_bill.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice"><i class="fas fa-print"></i></a></td>
            //     <td><a href="edit_bill.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><i class="fas fa-edit"></i></a></td>
            //     <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteBill"  title="Delete Invoice"><i class="fas fa-trash"></i></a></td>
            //   </tr>
            // ';
        }       
        ?>
      </table>	
</div>	
<?php include('footer.php');?>