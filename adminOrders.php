<?php
include("db.php");

if(isset($_GET['delete']))
{
  $delete_id = $_GET['delete'];
  $delete_query = mysqli_query($conn, "DELETE FROM tbl_order WHERE id = '$delete_id'");
  if($delete_query)
  {
    header('location:adminOrders.php');
    $message[] = 'order deleted';
  }
  else
  {
    header('location:adminOrders.php');
    $message[] = 'order could not be deleted';
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="stylesnav.css">
       <!-- Bootstrap -->
       <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <!--shopping cart icon link-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#"><img src="img/LOGO1.png">  admin panel</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
    <div class="navbar-nav">
      <a class="nav-item nav-link" href="adminOrders.php">Orders</a>
      <a class="nav-item nav-link" href="adminProducts.php">Displayed Products</a>
    </div>
  </div>
</nav>
<h1> Your Pending Orders </h1>

<section class="display-product-table">
    <table>

      <thead>
        <th>name</th>
        <th>cell</th>
        <th>email</th>
        <th>payment method</th>
        <th>address</th>
        <th>suburb</th>
        <th>items</th>
        <th>total amount</th>
      </thead>

      <tbody>
        <?php
        
        $select_products = mysqli_query($conn, "SELECT * FROM tbl_order");
        if(mysqli_num_rows($select_products) > 0)
        
        {
          while($row = mysqli_fetch_assoc($select_products))
          {
            ?>

            <tr>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['cell']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><?php echo $row['method']; ?></td>
              <td><?php echo $row['address']; ?></td>
              <td><?php echo $row['suburb']; ?></td>
              <td><?php echo $row['total_products']; ?></td>
              <td><?php echo $row['total_price']; ?></td>
              <td>
                <a href='adminOrders.php?delete=<?php echo $row['id']; ?>' class="btn-admin-remove-product" onclick='return confirm("are you sure you wante to remove this order?")'><i class="fa fa fa-trash">delete</i></a>
              </td>
            </tr>

        <?php
          };
        }
        else
        {
          echo "<span>no orders to show</span>";
        }
        ?>
      </tbody>

    </table>


</body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</html>