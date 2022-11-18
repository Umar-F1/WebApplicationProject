<?php

include("db.php");

if(isset($_POST['update_update_btn']))
{
    $update_value = $_POST['update_quantity'];
    $update_id = $_POST['update_quantity_id'];
    $update_quantity_query = mysqli_query($conn, "UPDATE cart SET quantity = '$update_value'
    WHERE id = '$update_id'");

    if($update_quantity_query)
    {
        header('location: cart.php');
    }
};

if(isset($_GET['remove']))
{
  $delete_id = $_GET['remove'];
  $delete_query = mysqli_query($conn, "DELETE FROM cart WHERE id = '$delete_id'");
  if($delete_query)
  {
    header('location:cart.php');
    $message[] = 'producted deleted';
  }
  else
  {
    header('location:cart.php');
    $message[] = 'producted could not be deleted';
  }
};

if(isset($_GET['delete_all']))
{
  $delete_id = $_GET['delete_all'];
  $delete_query = mysqli_query($conn, "DELETE * FROM cart");
  if($delete_query)
  {
    header('location:cart.php');
    $message[] = 'all items removed';
  }
  else
  {
    header('location:cart.php');
    $message[] = 'items could not be removed';
  }
};
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

include_once('navbar.php');
?>

<body>

    <div class="container3">

    <section class="shopping-cart-page">

    <h1>Your Cart</h1>

    <table>
        <thead>
            <th>image</th>
            <th>name</th>
            <th>description</th>
            <th>price</th>
            <th>quantity</th>
            <th>total price</th>
        </thead>

        <thbody>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php

        $select_cart = mysqli_query($conn, "SELECT * FROM cart");
        $grand_total = 0;


        if(mysqli_num_rows($select_cart) > 0)
        {
            while($fetch_cart = mysqli_fetch_assoc($select_cart))
            {
        ?>

            <tr>
                <td><img src="img/<?php echo $fetch_cart['img']; ?>" height="200" width="200"></td>
                <td><?php echo $fetch_cart['name']; ?></td>
                <td><?php echo $fetch_cart['prod_desc']; ?></td>
                <td>R<?php echo number_format($fetch_cart['price']); ?></td>
                <td>
                    <form action="" method="post">

                    <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                    <input type="number" name="update_quantity" min="1" value="<?php echo $fetch_cart['quantity']; ?>">
                    <input type="submit" class="btn" value="update" name="update_update_btn">
                    </form>
                </td>
                <td>R<?php echo $subtotal = number_format($fetch_cart['price'] * $fetch_cart['quantity'])?></td>
                <td><a href='cart.php?remove=<?php echo $fetch_cart['id']; ?>' onclick='return confirm("remove item from cart?")' class="delete-btn"> <i class="fa fa-trash"></i></a></td>
            </tr>

                <?php
                $grand_total += $subtotal;
            };
        };

        ?>
        <tr class="table-bottom">
            <td><a href="shop.php" style="margin-top: 0;">continue shopping?</a></td>
            <td colspan="3">total amount</td>
            <td>R<?php echo $grand_total; ?></td>
            <td><a href='cart.php?delete_all=<?php echo $fetch_cart['id']; ?>' onclick="return confirm('are sure you want to delete all items?');" class="delete-btn"><i class="fa fa-trash"></i>delete all</a></td>
        </tr>
        </thbody>
    </table>

    <div class="checkout-btn">
        <a href="checkout.php" class="btn-checkout <?= ($grand_total > 1)?'': 'disabled';?>">Proceed to checkout</a>
    </div>

    </section>

    </div>
</body>

<?php

include_once("footertest.php")

?>
</html>