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
    echo '</div>';
}

function display_cart()
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
    }
}


?>