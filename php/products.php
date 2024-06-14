<?php
session_start();
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>

        function addToCart(productId) {
            $.ajax({
                url: './shopping-cart.php',
                type: 'POST',
                data: {
                    product_id: productId,
                    ajax: true
                },
                success: function (response) {
                    showNotification('Product added to cart!');
                    $("#cartQuantity").load(window.location.href + " #cartQuantity");
                },
                error: function () {
                    showNotification("Error: Can't add to shopping cart", true);
                }
            });
        }

        function showNotification(message, isError = false) {

            var notification = document.createElement('div');
            notification.className = isError ? 'notification error' : 'notification';
            notification.textContent = message;


            document.body.appendChild(notification);


            setTimeout(function () {
                $(notification).fadeOut('slow', function () {
                    $(this).remove();
                });
            }, 3000);
        }

    </script>

</head>

<body>

    <?php require 'partials/nav.php'; ?>

    <main>

        <?php
        $products = json_decode(file_get_contents('../assets/data.json'), true);
        ?>


        <div class="container mt-5">
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" class="card-img-top"
                                alt="<?php echo htmlspecialchars($product['product']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['product']); ?></h5>
                                <p class="card-text">$<?php echo htmlspecialchars($product['price']); ?></p>
                                <button onclick="addToCart(<?php echo $product['id']; ?>)" class="btn btn-primary">Add to
                                    Cart</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <?php require ('partials/footer-nav.php');
    ?>
</body>

</html>