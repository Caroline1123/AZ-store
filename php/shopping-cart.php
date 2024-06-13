<?php

// This will have to be in the index.php file!!
// Start a session if none is active to store cart data
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Also needs to be on index.php : creates an empty shopping cart if no cart existed
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [
        "product_id" => [],
        "quantity" => []
    ];
}

// Links form to modify quantity to proper function(add/ remove)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = intval($_POST['product_id']);
    $action = $_POST['action'];
    if ($_POST['action'] == 'add') {
        add_item($product_id);
    } elseif ($_POST['action'] == 'remove') {
        remove_item($product_id);
    }
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
        //should not happen that user tries to remove one item which is not already in the cart, but you never know... 
    } else {
        // If the item quantity is one, remove the product line entirely.
        if ($_SESSION["cart"]["quantity"][$product_index] === 1) {
            unset($_SESSION["cart"]["quantity"][$product_index]);
            unset($_SESSION["cart"]["product_id"][$product_index]);

            $_SESSION["cart"]["product_id"] = array_values($_SESSION["cart"]["product_id"]);
            $_SESSION["cart"]["quantity"] = array_values($_SESSION["cart"]["quantity"]);
            // if item exists in the cart, decrease its quantity by 1
        } else {
            $_SESSION["cart"]["quantity"][$product_index] -= 1;
        }
    }
}

function displayTotal($total)
{
    // TO DO !
}
function displayCart()
{
    $productsJson = file_get_contents('./../assets/data.json');
    $products = json_decode($productsJson, true);
    $total = 0;
    // Displays a default text if there's no item added to cart. 
    // TO DO : make it a bit "prettier"
    if (count($_SESSION['cart']['product_id']) === 0) {
        echo "no item found in the cart";
    } else {
        for ($i = 0; $i < count($_SESSION["cart"]["product_id"]); $i++) {
            // Retrieve the json object corresponding to product id.
            foreach ($products as $product) {
                if ($product["id"] === $_SESSION["cart"]["product_id"][$i]) {
                    echo "<div class='item border-bottom d-flex p-2'>";
                    echo "<img class='rounded bg-light' src=" . $product['image_url'] . " alt='Product Image'>";
                    echo "<div>";
                    echo "<p class='fw-bold'>" . $product["product"] . "</p>";
                    echo "<p>" . $product["price"] * $_SESSION["cart"]["quantity"][$i] . " € </p>";
                    echo "Quantity     
                    <form method='post' class='cart-form d-inline'>
                        <input type='hidden' name='product_id' value='" . $product["id"] . "'>
                        <input type='hidden' name='action' value='remove'>
                        <button class='cart-button btn btn-secondary rounded-circle p-1' type='submit'>-</button>
                    </form>"
                        . $_SESSION["cart"]["quantity"][$i] . "
                    <form method='post' class='cart-form d-inline'>
                        <input type='hidden' name='product_id' value='" . $product["id"] . "'>
                        <input type='hidden' name='action' value='add'>
                        <button class='cart-button btn btn-secondary rounded-circle  p-1' type='submit'>+</button>
                    </form>";
                    // echo "TOTAL: " . " € <br>";
                    echo "</div>";
                    echo "</div>";
                    $total += $product["price"] * $_SESSION["cart"]["quantity"][$i];
                }
            }
        }
        echo $total;
    }
}
// TO DO - Split logic so that functions can be called from elsewhere without adding the HTML (create shopping-cart view and shopping cart functions in 2 sep. folders)

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

<body>
    <?php require 'partials/nav.php' ?>
    <h3 class="m-3 text-center">Your Order </h3>
    <div class="shopping-cart border rounded d-flex m-3 p-2">
        <div class="overview d-flex flex-column">
            <?php displayCart() ?>
        </div>
        <div class="summary p-4 rounded d-flex flex-column">
            <h4>Order Summary</h4>
            <p class="d-flex border-bottom">Subtotal<span class="total"></span></p>
            <p class="d-flex border-bottom">VAT<span class="total"></span></p>
            <p class="d-flex border-bottom">Total<span class="total"></span></p>

            <button>Checkout</button>
        </div>
    </div>
    <?php require 'partials/footer-nav.php' ?>
</body>