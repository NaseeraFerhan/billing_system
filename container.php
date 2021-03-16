</head>
<body class="">
    <nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
<a href="index.php" class="navbar-brand">Billing System</a>
  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <?php if(isset($_SESSION['userid'])) { ?>
      <li class="nav-item  dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" >
          Bill
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="bill_list.php">Bill List</a>
          <a class="dropdown-item" href="create_bill.php">Create Bill</a>
        </div>
      </li>

      <li class="nav-item  dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" >
          Inventory
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="add_items.php">Add Item</a>
          <!-- <a class="dropdown-item" href="create_bill.php">Create Bill</a> -->
        </div>
      </li>

      <?php 
         if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']==1){
           ?>

<li class="nav-item  dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" >
          Staff
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="add_user.php">Add Staff</a>
          <!-- <a class="dropdown-item" href="create_bill.php">Create Bill</a> -->
        </div>
      </li>

           <?php
         }
      ?>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Logged in <?php echo $_SESSION['user']; ?></a>
        <div class="dropdown-menu" >
          <a class="dropdown-item" href="action.php?action=logout">Logout</a>
        </div>
      </li>
      <?php } ?>
    </ul>
  </div> 
</nav>
	<div class="container">
    <div class="card">
      <div class="card-body">
        
