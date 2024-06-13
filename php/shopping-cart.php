<?php
session_start();

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function display_cart()
{
    $productsJson = file_get_contents('./../assets/data.json');
    $products = json_decode($productsJson, true);
    $total = 0;

    // Displays a default text if there's no item added to cart.
    if (count($_SESSION['cart']['product_id']) === 0) {
        echo "no item found in the cart";
    } else {
        for ($i = 0; $i < count($_SESSION["cart"]["product_id"]); $i++) {
            // Retrieve the json object corresponding to product id.
            foreach ($products as $product) {
                if ($product["id"] === $_SESSION["cart"]["product_id"][$i]) {
                    echo "<div class='item border rounded d-flex mb-3'>";
                    echo "<img class='img-thumbnail' src='" . $product['image_url'] . "' alt='Product Image' width='100' height='100'>";
                    echo "<div class='p-2'>";
                    echo $product["product"] . "<br>";
                    echo $product["price"] . " € <br>";
                    echo "Quantity: <span id='quantity_" . $product['id'] . "'>" . $_SESSION["cart"]["quantity"][$i] . "</span> ";
                    echo "<button onclick='updateCart(" . $product['id'] . ", \"increase\")' class='btn btn-success btn-sm'>+</button> ";
                    echo "<button onclick='updateCart(" . $product['id'] . ", \"decrease\")' class='btn btn-warning btn-sm'>-</button> ";
                    echo "TOTAL: " . $product["price"] * $_SESSION["cart"]["quantity"][$i] . " € <br>";
                    echo "<form method='post' action='shopping-cart.php' class='d-inline'>";
                    echo "<input type='hidden' name='remove_product_id' value='" . $product['id'] . "'>";
                    echo "<button type='submit' class='btn btn-danger btn-sm mt-2'>Remove</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";
                    $total += $product["price"] * $_SESSION["cart"]["quantity"][$i];
                }
            }
        }
    }
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