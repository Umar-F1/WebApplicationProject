
<?php
    include ("db.php");

    session_start();

    if(isset($_POST['add_to_cart']))
    {
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_desc = $_POST['product_desc'];
        $product_image = $_POST['product_image'];
        $product_quantity = 1;

        $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE name = '$product_name'");

        ///////////////check with sir about the error message and possible js on this method///
        if(mysqli_num_rows($select_cart) > 0)
        {
           $message[] = 'Item already added to cart';
        }
        else
        {
            $insert_product = mysqli_query($conn, "INSERT INTO cart(name, price, prod_desc, img, quantity)
            VALUES('$product_name', '$product_price', '$product_desc', '$product_image', '$product_quantity' )");
            $message[] = 'Item added to cart successfully';
        }

        $_SESSION['prod_name'] = $product_name;
        $_SESSION['prod_price'] = $product_price;
        $_SESSION['prod_desc'] = $product_desc;
        $_SESSION['prod_image'] = $product_image;
        $_SESSION['prod_quantity'] = $product_quantity;
        
    }

?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesnav.css">
    <title>Aisha's Cupcakes</title>
    
</head>

<?php

if(isset($message))
{
    foreach($message as $message)
    {
        echo '<div class="message"><span>'.$message.'</span></div>';
    };
};

?>

<?php
include_once('navbar.php');
?>
<body>

<?php

$select_rows = mysqli_query($conn, "SELECT * FROM cart") or die('query failed');
$row_count = mysqli_num_rows($select_rows);


?>
    
<section class="products">
   <div class="shop-container">

        <?php

        $select_products = mysqli_query($conn, 'SELECT * FROM products');
        if(mysqli_num_rows($select_products) > 0)
        {
            while($fetch_product = mysqli_fetch_assoc($select_products)) 
            {

            
        
        ?>

        <form action="shop.php" method="post">
          <div class="box">
          <img src="img/<?php echo $fetch_product['img'];?>">
            <h3><?php echo $fetch_product['name']; ?></h3>
            <div class="prod_desc"><?php echo $fetch_product['prod_desc']; ?></div>
            <h2>R<?php echo $fetch_product['price']; ?></h2>

            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
            <input type="hidden" name="product_desc" value="<?php echo $fetch_product['prod_desc']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_product['img']; ?>">

            <input type="submit" class="btn_add_to_cart" value="add to cart" name="add_to_cart">
          </div>
                
        </form>
        <?php
            };
        };
        ?>
    </div>
</section>

</body>
<?php
        include_once('footertest.php');
    ?>
</html>
    
       