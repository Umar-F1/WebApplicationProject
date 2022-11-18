<?php

include("db.php");

session_start();

if(isset($_POST['order_btn']))
{
    $name = $_POST['name'];
    $cell = $_POST['cell'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $address = $_POST['address'];
    $suburb = $_POST['suburb'];

    $cart_query = mysqli_query($conn, "SELECT * FROM cart");
    $price_total = 0;

    if(mysqli_num_rows($cart_query) > 0)
    {
        while($product_item = mysqli_fetch_assoc($cart_query))
        {
            $product_name[] = $product_item['name'] .' ('. $product_item['quantity']. ' )';
            $product_price = number_format($product_item['price'] * $product_item['quantity']);
            $price_total += $product_price;
        };
    };

    $total_product = implode(', ', $product_name);
    $detail_query = mysqli_query($conn, "INSERT INTO tbl_order (name, cell, email, method, address, suburb, total_products, total_price) VALUES ('$name', '$cell', '$email', '$method', '$address', '$suburb', '$total_product', '$price_total')");

    if($cart_query && $detail_query)
    {
        echo "
    <div class='order-message-container'>
        <div class='message-container'>
            <h3>Thank you for supporting us!</h3>
            <div class='order-detail'>
                <span>".$total_product."</span>
                <span class='total'> Total : ".$price_total."</span>
            </div>
            <div class='customer-details'>
                <p> your name:<span>".$name."</span></p>
                <p> your cell:<span>".$cell."</span></p>
                <p> your email:<span>".$email."</span></p>
                <p> your address:<span>".$address.", ".$suburb."</span></p>
                <p> your payment method:<span>".$method."</span></p>
                <p>(*Please ensure that you make payment when your order arrives*)</p>
            </div>
            <a href='shop.php' class='btn'>continue shopping</a>
            </div>
        </div>
        ";
    }
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

<body>

    <!--shopping cart icon link-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    </ul>
    </nav>

    <div class="container">

    <section class="checkout-form">

        <h1>COMPLETE YOUR ORDER</h1>

        <form name="checkout" action="" method="post">

            <div class="display-order">

            <?php

            $select_cart = mysqli_query($conn, "SELECT * FROM cart");
            $total = 0;
            $grand_total = 0;

            if(mysqli_num_rows($select_cart) > 0)
            {
                while($fetch_cart = mysqli_fetch_assoc($select_cart))
                {
                    $total_price = number_format($fetch_cart['price'] * $fetch_cart['quantity']);
                    $grand_total = $total += $total_price;
            ?>
            <span><?= $fetch_cart['name']; ?>(<?= $fetch_cart['quantity']; ?>)</span>
            <?php
                }
                }else{
                    echo"<div class='display-order'><span>your cart is empty!</span></div>";
                }

            ?>
            <span class="grand-total">Total: <?= $grand_total; ?></span>
            </div>

            <div class="flex">
                <div class="inputBox">
                    <span>Your name</span>
                    <input type="text" placeholder="enter your name" name="name">
                </div>
                <div class="inputBox">
                    <span>Your cell</span>
                    <input type="number" placeholder="enter your cell" name="cell">
                </div>
                <div class="inputBox">
                    <span>Your email</span>
                    <input type="email" placeholder="enter your email" name="email">
                </div>
                <div class="inputBox">
                    <span>Payment method</span>
                    <select name="method">
                        <option value="cash on delivery" selected>cash on delivery</option>
                        <option value="credit card">credit card</option>
                        <option value="EFT">EFT</option>
                    </select>
                </div>
                <div class="inputBox">
                    <span>Address</span>
                    <input type="text" placeholder="e.g. 1 elm street" name="address">
                </div>
                <div class="inputBox">
                    <span>Suburb</span>
                    <input type="text" placeholder="e.g. Stanger Manor" name="suburb">
                </div>
            </div>
            <input type="submit" value="order now" name="order_btn" class="btn" onclick='validateCheckout()'>
            <a class="fa fa-sign-out" href="logout.php">Logout</a>
        </form>
        

    </section>


    </div>

<?php
    include_once('footertest.php');
?>

<script src="validate.js"></script>
</body>

</html>