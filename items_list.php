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
	  <h2 class="title mt-5">Products</h2>
	  <?php #include('menu.php');?>			  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Item ID</th>
            <th>Item Name</th>
            <th>Price</th>
            <!-- <th>Delete</th> -->
          </tr>
        </thead>
        <?php		
	    	$itemsList = $db->getItems();
        foreach($itemsList as $item){
		


      echo '
              <tr>
                <td>'.$item["id"].'</td>
                
                <td>'.$item["item_name"].'</td>
                <td>'.$item["price"].'</td>
                </tr>
            ';
            //                <td><a href="#" id="'.$item["id"].'" class="deleteItem"  title="Delete Item"><i class="fas fa-trash"></i></a></td>


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