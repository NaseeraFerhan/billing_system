<?php 
session_start();
include('header.php');
include 'DbConnect.php';
$db = new DbConnect();
$db->checkLoggedIn();

$invoice = $db->getInvoice($_GET['invoiceId']);
$invoiceItems = $db->getInvoiceItems($_GET['invoiceId'])
?>
<title>Bills : Billing System</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>



	<div class="container">		
	  <h2 class="title mt-5">Bill Details</h2>
	  <?php #include('menu.php');?>			  
      <table id="data-table" class="table table-condensed table-striped">

        <tr>
        <td>Customer Name:</td>
        <td><?php echo $invoice['order_receiver_name'] ?></td>
        </tr>
        
        <tr>
        <td>Customer Address:</td>
        <td><?php echo $invoice['order_receiver_address'] ?></td>
        </tr>

        <tr>
        <td>Biller:</td>
        <td></td>
        </tr>

        <tr>
        <td>Bill Date:</td>
        <td><?php echo date("d/M/Y, H:i:s", strtotime($invoice['order_date'])) ?></td>
        <tr><td colspan="2"><h4>Items</h4></td></tr>
        </tr>

        <tr>
        <td>No.</td>
        <td>Item Name</td>
        <td>Quantity</td>
        <td>Total</td>
        </tr>

		<?php foreach($invoiceItems as $item){ ?>
        <tr>
		<td><?php echo $item['item_code'] ?></td>
		<td><?php echo $item['item_name'] ?></td>
		<td><?php echo $item['order_item_quantity'] ?></td>
		<td><?php echo $item['order_item_final_amount'] ?></td>
        </tr>
		<?php } ?>

        </table>

		<button onclick="window.history.back();" type="button" class="btn btn-secondary">Back</button>
</div>	
<?php include('footer.php');?>