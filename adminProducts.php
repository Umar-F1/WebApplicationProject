<?php
include('db.php');

if(isset($_POST['add_product']))
{
  $p_name = $_POST['p_name'];
  $p_description = $_POST['p_description'];
  $p_price = $_POST['p_price'];
  $p_image = $_FILES['p_image']['name'];
  $p_image_tmp_name = $_FILES['p_image']['tmp_name'];
  $p_image_folder = 'img/'.$p_image;

  $insert_query = mysqli_query($conn, "INSERT INTO products(name, prod_desc, price, img)
  VALUES ('$p_name', '$p_description)', '$p_price', '$p_image')");

  if($insert_query)
  {
    move_uploaded_file($p_image_tmp_name, $p_image_folder);
    $message[] = 'producted added successfully';
  }
  else
  {
    $message[] = 'producted could not be added';
  }
};

if(isset($_GET['delete']))
{
  $delete_id = $_GET['delete'];
  $delete_query = mysqli_query($conn, "DELETE FROM products WHERE menu_id = '$delete_id'");
  if($delete_query)
  {
    header('location:adminProducts.php');
    $message[] = 'producted deleted';
  }
  else
  {
    header('location:adminProducts.php');
    $message[] = 'producted could not be deleted';
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

<?php
if(isset($message))
{
  foreach($message as $message)
  echo'<div class="add-product-message"><span>'.$message.'</span><i class="fa fa-times" onclick="this.parentElement.style.display = "none";"></i></div>';
};
?>
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

<div class="form-container"></div>

<section class="admin-products-form">
    <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
        <h3> add new products </h3>
        <input type="text" name="p_name" placeholder="enter the product name" class="box" required>
        <input type="text" name="p_description" placeholder="enter the product description" class="box" required>
        <input type="number" name="p_price" placeholder="enter the product price" class="box" required>
        <input type="file" name="p_image" accept="image/png, image/jpg, image/jpeg" class="box" required>
        <input type="submit" value="add product" name="add_product" class="btn-admin-add-product">

    </form>
</section>

<section class="display-product-table">
    <table>

      <thead>
        <th>product image</th>
        <th>product name</th>
        <th>product description</th>
        <th>product price</th>
        <th>action</th>
      </thead>

      <tbody>
        <?php
        
        $select_products = mysqli_query($conn, "SELECT * FROM products");
        if(mysqli_num_rows($select_products) > 0)
        
        {
          while($row = mysqli_fetch_assoc($select_products))
          {
            ?>

            <tr>
              <td><img src="img/<?php echo $row['img']; ?>" height="200" width="200"></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['prod_desc']; ?></td>
              <td>R<?php echo $row['price']; ?></td>
              <td>
                <a href='adminProducts.php?delete=<?php echo $row['menu_id']; ?>' class="btn-admin-remove-product" onclick='return confirm("are you sure you wante to remove this item?")'><i class="fa fa fa-trash">delete</i></a>
              </td>
            </tr>

        <?php
          };
        }
        else
        {
          echo "<span>no producted added</span>";
        }
        ?>
      </tbody>

    </table>
</section>

</body>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
</html>