<?php

// This will have to be in the index.php file!!
// Start a session if none is active to store cart data

session_start();

// Also needs to be on index.php : creates an empty shopping cart if no cart existed
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [
        "product_id" => [],
        "quantity" => []
    ];
}

// Links form to modify quantity to proper function(add/ remove)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['product_id'])) {
        $product_id = intval($_POST['product_id']);
        $action = isset($_POST['action']) ? $_POST['action'] : 'increase';

        if ($action === 'increase') {
            add_item($product_id);
        } elseif ($action === 'decrease') {
            decrease_item($product_id);
        }

        if (isset($_POST['ajax'])) {
            echo json_encode(['status' => 'success']);
            exit();
        }
    } elseif (isset($_POST['remove_product_id'])) {
        remove_item((int)$_POST['remove_product_id']);

        if (isset($_POST['ajax'])) {
            echo json_encode(['status' => 'success']);
            exit();
        }
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

function decrease_item($product_id) {
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
function remove_item($product_id) {
    $product_index = array_search($product_id, $_SESSION["cart"]["product_id"]);
    if ($product_index !== false) {
        unset($_SESSION["cart"]["quantity"][$product_index]);
        unset($_SESSION["cart"]["product_id"][$product_index]);
        $_SESSION["cart"]["product_id"] = array_values($_SESSION["cart"]["product_id"]);
        $_SESSION["cart"]["quantity"] = array_values($_SESSION["cart"]["quantity"]);
    }
}

function display_summary()
{
    $productsJson = file_get_contents('./../assets/data.json');
    $products = json_decode($productsJson, true);
    $total = 0;

    for ($i = 0; $i < count($_SESSION["cart"]["product_id"]); $i++) {
        // Retrieve the json object corresponding to product id.
        foreach ($products as $product) {
            if ($product["id"] === $_SESSION["cart"]["product_id"][$i]) {
                $total += $product["price"] * $_SESSION["cart"]["quantity"][$i];
            }
        }
    }
    // If total cost is above 200EUR, then no shipping fee.
    if ($total > 200) {
        $shipping = 0;
    } else {
        $shipping = 16;
    }
    echo '
    <div class="summary p-4 rounded d-flex flex-column">
        <h4 class="mb-4 text-center">Summary</h4>
        <p class=" total d-flex border-bottom">Subtotal<span>' . number_format($total, 2) . ' €</span></p>
        <p class=" total d-flex border-bottom">Shipping<span>' . number_format($shipping, 2) . ' €</span></p>
        <p class=" total fw-bold d-flex border-bottom mt-4">Total<span>' . number_format($total + $shipping, 2) . ' €</span></p>';
    if (($total > 0) && (basename($_SERVER['PHP_SELF']) != 'checkout.php')) {
        echo "<a href='checkout.php'><button class='btn btn-primary btn-lg w-100'>Checkout</button></a>";
    }
    elseif (basename($_SERVER['PHP_SELF']) != 'checkout.php')
    echo '</div>';
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
        echo "<div class='total'>Total: " . $total . " €</div>";
    }
}