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
        <td><?php $biller = $db->getUser($invoice['user_id'])[0];
        echo $biller['first_name'].' '.$biller['last_name'].'<br>';
        echo $biller['address'];
        ?>
        </td>
        </tr>

        <tr>
        <td>Bill Date:</td>
        <td><?php echo date("d M Y, H:i", strtotime($invoice['order_date'])) ?></td>
        <tr><td colspan="2"><h4>Items</h4></td></tr>
        </tr>

        <tr>
        <td>No.</td>
        <td>Item Name</td>
        <td>Quantity</td>
        <td>Total</td>
        </tr>

		<?php foreach($invoiceItems as $count=>$item){ ?>
        <tr>
		<td><?php echo $count+1; ?></td>
		<td><?php 
        $itemData = $db->getItem($item['item_code'])[0];
        echo $itemData['item_name'] ?></td>
		<td><?php echo $item['order_item_quantity'] ?></td>
		<td><?php echo $item['order_item_quantity'] * $itemData['price'] ?></td>
        </tr>
		<?php } ?>
        <td colspan="2"></td>
        <td><h4>Total</h4></td>
        <td><h5><?php echo $invoice['order_total_amount'] ?></h5></td>

        </table>

		<button onclick="window.history.back();" type="button" class="btn btn-secondary">Back</button>
</div>	
<?php include('footer.php');?>