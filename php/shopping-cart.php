<?php

// This will have to be in the index.php file!! Start a session when opening the page directly.
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
    $_SESSION["cart"] = [
        "product_id" => [],
        "quantity" => []
    ];
}

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

// Removes one item from the cart. 
//Parameter : int :  product ID (must match data.json product ID)
function remove_item($product_id)
{
    $product_index = array_search($product_id, $_SESSION["cart"]["product_id"]);
    if ($product_index === false) {
        //
    } else {
        if ($_SESSION["cart"]["quantity"][$product_index] === 1) {
            unset($_SESSION["cart"]["quantity"][$product_index]);
            unset($_SESSION["cart"]["product_id"][$product_index]);

            $_SESSION["cart"]["product_id"] = array_values($_SESSION["cart"]["product_id"]);
            $_SESSION["cart"]["quantity"] = array_values($_SESSION["cart"]["quantity"]);
        } else {
            $_SESSION["cart"]["quantity"][$product_index] -= 1;
        }
    }
}

add_item(1);
add_item(2);
add_item(1);
remove_item(1);
add_item(25);

// Shopping cart page should show : product img, product name, product price and quantity

if (count($_SESSION['cart']['product_id']) === 0) {
    "no item found in the cart";
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

    <script src="https://kit.fontawesome.com/8a245e3c89.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="./../assets/css/styles.css">

<body>
    <?php require 'partials/nav.php' ?>
    <?php require 'partials/footer-nav.php' ?>

</body>