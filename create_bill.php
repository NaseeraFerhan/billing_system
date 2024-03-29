<?php 
   session_start();
   include('header.php');
   include 'DbConnect.php';
   $db = new DbConnect();
   $db->checkLoggedIn();
   $validateError = '';
   if(!empty($_POST['customerName']) && $_POST['customerName']) {	
   	if(!empty($_POST['productCode'])&& $_POST['productCode'][0]){
         $db->saveInvoice($_POST);
   	   header("Location:bill_list.php");	
      } else {
         $validateError = "Atleast add One item";
      }
      
   } else {
      if($_POST){
         $validateError = "Error Creating Bill";
      }
   } 
   ?>
<title>New Invoice : Billing System</title>
<script src="js/invoice.js"></script>
<script>

$.getJSON('get_items.php', {}, function(data) {
    $.each(data, function(index, element) {
       var opt = '<option value="'+element.id+'">'+element.item_name+'</option>';
      $('#productName_1').append(opt);     
    });
});

function selectItem(sel)
{
   var countdata = sel.id
   var count = countdata[12,countdata.length-1]

   $.getJSON('get_items.php', {id:sel.value}, function(data) {
    $.each(data, function(index, element) {

      if(element.id == sel.value){
         $('#price_'+count).val(element.price)
         $('#quantity_'+count).val('1')
         tax = (parseFloat(element.tax)/100)
         $('#total_'+count).val((parseFloat(element.price)).toString())
         $('#tax_'+count).val(tax.toString())
         $('#productCode_'+count).val(element.id)
         calculateTotal()
      }

       var opt = '<option value="'+element.id+'">'+element.item_name+'</option>';
      $('#productName_1').append(opt);     
    });
});

}
</script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
   <div class="cards">
     <div class="card-bodys">
       <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
      <div class="load-animate animated fadeInUp">
         <div class="row">
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
               <h2 class="title">New Bill</h2>
               <?php 
                if($validateError){ ?>
                  <div class="alert alert-warning"><?php echo $validateError ; ?></div>
                <?php
                }
               ?>
               
               <?php #include('menu.php');?> 
            </div>
         </div>
         <input id="currency" type="hidden" value="₹">
         <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
               <h3>Biller,</h3>
               <?php echo $_SESSION['user']; ?><br> 
               <?php echo $_SESSION['address']; ?><br>  
               <?php echo $_SESSION['mobile']; ?><br>
               <?php echo $_SESSION['email']; ?><br>  
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
               <h3>To,</h3>
               <div class="form-group">
                  <input type="text" class="form-control" name="customerName" id="customerName" placeholder="Customer Name" autocomplete="off">
               </div>
               <div class="form-group">
                  <textarea class="form-control" rows="3" name="address" id="address" placeholder="Your Address"></textarea>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
               <table class="table table-condensed table-striped" id="invoiceItem">
                  <tr>
                     <th width="2%">
                      <div class="custom-control custom-checkbox mb-3">
                        <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                        <label class="custom-control-label" for="checkAll"></label>
                        </div>
                    </th>
                     <!-- <th width="15%">Item No</th> -->
                     <th width="38%">Item Name</th>
                     <th width="15%">Quantity</th>
                     <th width="15%">Price</th>
                     <th width="15%">Total</th>
                  </tr>
                  <tr>
                     <td><div class="custom-control custom-checkbox">
                        <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
                        <label class="custom-control-label" for="itemRow_1"></label>
                        </div></td>
                     <input readonly type="hidden" name="productCode[]" id="productCode_1" value="" class="form-control" autocomplete="off">
                     <td><select onchange="selectItem(this);" name="productName[]" id="productName_1" class="form-control">
                     <option value="">Select Item</option>
                     </select>
                     </td>
                     <!-- <td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td> -->
                     <!-- <input type="hidden" name="tax[]" id="tax_1"/> -->
                     <td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
                     <td><input readonly type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
                     <td><input readonly type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
                  </tr>
               </table>
            </div>
         </div>
         <div class="row">
            <div class="col-xs-12">
               <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
               <button class="btn btn-success" id="addRows" type="button">+ Add More</button>
            </div>
         </div>
         <!-- <div class="row">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Subtotal: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">₹</span>
            </div>
            <input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
          </div>
              </div>
          </div> -->
          
          <!-- <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Tax Amount: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">₹</span>
            </div>
            <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Tax Amount">
          </div>
              </div>
          </div> -->
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group mt-3 mb-3 ">
              <label>Total: &nbsp;</label>
                 <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text currency">₹</span>
            </div>
             <input value="" type="number" class="form-control" name="total" id="total" placeholder="Total">
          </div>
              </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            
              </div>
          </div>
          
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
               
               <br>
               <div class="form-group">
                  <input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
                  <input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Bill" class="btn btn-success submit_btn invoice-save-btm">           
               </div>
            </div>
         </div>
         <div class="clearfix"></div>
      </div>
   </form>
     </div>
   </div>
</div>
</div>	
<?php include('footer.php');?>
