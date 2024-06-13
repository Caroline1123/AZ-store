<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require ('cart-functions.php');
// Adds one item to the cart
//Parameter : int :  product ID (must match data.json product ID)
function add_item($product_id)
{
    $product_index = array_search($product_id, $_SESSION["cart"]["product_id"]);
    if ($product_index === false) {
        $_SESSION["cart"]["product_id"][] = $product_id;
        $_SESSION["cart"]["quantity"][] = 1;
    } else {
        $_SESSION["cart"]["quantity"][$product_index] += 1;
    }
}

function decrease_item($product_id)
{
    $product_index = array_search($product_id, $_SESSION["cart"]["product_id"]);
    if ($product_index !== false) {
        if ($_SESSION["cart"]["quantity"][$product_index] === 1) {
            remove_item($product_id);
        } else {
            $_SESSION["cart"]["quantity"][$product_index] -= 1;
        }
    }
}

// Removes one item from the cart. 
//Parameter : int :  product ID (must match data.json product ID)
function remove_item($product_id)
{
    $product_index = array_search($product_id, $_SESSION["cart"]["product_id"]);
    if ($product_index !== false) {
        unset($_SESSION["cart"]["quantity"][$product_index]);
        unset($_SESSION["cart"]["product_id"][$product_index]);
        $_SESSION["cart"]["product_id"] = array_values($_SESSION["cart"]["product_id"]);
        $_SESSION["cart"]["quantity"] = array_values($_SESSION["cart"]["quantity"]);
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AZ-store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <script defer src="./../assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/8a245e3c89.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./../assets/css/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function updateCart(productId, action) {
            $.ajax({
                url: 'cart-functions.php',
                type: 'POST',
                data: {
                    product_id: productId,
                    action: action,
                    ajax: true
                },
                success: function (response) {
                    location.reload();
                },
                error: function () {
                    alert("error updating cart");
                }
            });
        }
    </script>
</head>

<body>
    <?php require 'partials/nav.php' ?>
    <h3 class="m-3 text-center">Your Order </h3>
    <div class="shopping-cart border rounded d-flex m-3 p-2">
        <div class="overview d-flex flex-column">
            <?php display_cart() ?>
        </div>
        <?php echo display_summary() ?>
    </div>
    <!-- <?php require 'partials/footer-nav.php' ?> -->
</body>