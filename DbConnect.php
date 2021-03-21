<?php
class DbConnect{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "project_billing";   
	private $invoiceUserTable = 'billing_users';	
    private $invoiceOrderTable = 'bills';
	private $invoiceOrderItemTable = 'bill_items';
	private $invoiceStockTable = 'stock_details';
	private $dbConnect = false;


    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }


	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}


	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}


	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile, isAdmin 
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}

	public function getUser($userId){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile, isAdmin 
			FROM ".$this->invoiceUserTable." 
			WHERE id='".$userId."'";
        return  $this->getData($sqlQuery);
	}
	
	public function getUsers(){
		$sqlQuery = "
			SELECT * 
			FROM ".$this->invoiceUserTable;
        return  $this->getData($sqlQuery);
	}


	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		


	public function saveInvoice($POST) {		
		$sqlInsert = "INSERT INTO ".$this->invoiceOrderTable."(user_id, order_receiver_name, order_receiver_address, order_total_amount) VALUES ('".$POST['userId']."', '".$POST['customerName']."', '".$POST['address']."', '".$POST['total']."')";		
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if($result){
		  echo "True";
		} else {
		  return mysqli_error($this->dbConnect);
		}
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, order_item_quantity) VALUES ('".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['quantity'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}       	
	}	


	// public function updateInvoice($POST) {
	// 	if($POST['invoiceId']) {	
	// 		$sqlInsert = "UPDATE ".$this->invoiceOrderTable." 
	// 			SET order_receiver_name = '".$POST['customerName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."' 
	// 			WHERE user_id = '".$POST['userId']."' AND order_id = '".$POST['invoiceId']."'";		
	// 		mysqli_query($this->dbConnect, $sqlInsert);	
	// 	}		
	// 	$this->deleteInvoiceItems($POST['invoiceId']);
	// 	for ($i = 0; $i < count($POST['productCode']); $i++) {			
	// 		$sqlInsertItem = "INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
	// 			VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
	// 		mysqli_query($this->dbConnect, $sqlInsertItem);			
	// 	}       	
	// }	


	public function getInvoiceList($isAdmin = 0){
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' order by order_date DESC";
		if($isAdmin)
		 $sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable." 
		  order by order_date DESC";
		return  $this->getData($sqlQuery);
	}	


	public function getInvoice($invoiceId){
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	

	public function getInvoiceItems($invoiceId){
		$sqlQuery = "SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '$invoiceId'";
		return  $this->getData($sqlQuery);	
	}
	public function getItem($itemId){
		$sqlQuery = "SELECT * FROM ".$this->invoiceStockTable." 
			WHERE id = '$itemId'";
		return  $this->getData($sqlQuery);	
	}


	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		return mysqli_query($this->dbConnect, $sqlQuery);				
	}


	public function deleteInvoice($invoiceId){
		$sqlQuery = "DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return $result;
	}
	public function deleteItem($id){
		$sqlQuery = "DELETE FROM ".$this->invoiceStockTable." 
			WHERE id = '".$id."'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		return $result;
	}

	public function getItems(){
		$sqlQuery = "SELECT * FROM ".$this->invoiceStockTable." ";
		return  $this->getData($sqlQuery);
	}

	public function saveItem($POST) {		
		$sqlInsert = "INSERT INTO ".$this->invoiceStockTable."(item_name, price) VALUES ('".$POST['itemName']."', '".$POST['itemPrice']."')";		
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if($result){
		  echo "True";
		} else {
		  return mysqli_error($this->dbConnect);
		}       	
	}	

	public function saveUser($POST) {		
		$sqlInsert = "INSERT INTO ".$this->invoiceUserTable."(email, password, first_name, last_name, mobile, address) VALUES ('".$POST['email']."', '".$POST['password']."', '".$POST['fname']."','".$POST['lname']."' , '".$POST['mobile']."','".$POST['address']."')";		
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if($result){
		  echo "True";
		} else {
		  return mysqli_error($this->dbConnect);
		}       	
	}	
}
?>
