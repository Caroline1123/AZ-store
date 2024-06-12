<?php

// This will have to be in the index.php file!! Start a session when opening the page directly.
if (session_status() != PHP_SESSION_ACTIVE) {
    session_start();
    $_SESSION["cart"] = [
        "product_id" => [],
        "quantity" => []
    ];
}

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

for ($i = 0; $i < count($_SESSION["cart"]["product_id"]); $i++) {
    echo "" . $_SESSION["cart"]["product_id"][$i] . ":" . $_SESSION["cart"]["quantity"][$i] . "<br>";
}

// Example of JSON object for product
//{
//     "id": 1,
//     "product": "Nike Air Max 270",
//     "price": 140,
//     "image_url": "/assets/img/nike-air-max-279.jpeg"
//   }

// Cart should have : id of product, quantity

// Shopping cart page should show : product img, product name, product price and quantity
$SESSION["cart"] = [
    // "products" => [],
];

if (count($_SESSION['cart']['product_id']) == 0) {
    echo "no items in the cart";
}

?>

<body>
    <h3>Your order</h3>

    <div>


    </div>

</body>