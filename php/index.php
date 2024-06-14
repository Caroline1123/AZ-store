<?php
// Start a session if none is active to store cart data
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Creates an empty shopping cart if no cart existed
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [
        "product_id" => [],
        "quantity" => []
    ];
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

<body class="mx-5">

    <header>
        <?php require ('partials/nav.php');
        ?>
    </header>

    <main>
        <div class="banner container-fluid d-flex flex-row my-3 p-0">
          <?php require('partials/banner.php');
          ?>
        </div>
        <div class="last-products my-3 pt-3">
            <h5><span class="blue">Our </span>last products</h5>
            <?php require('partials/last-products.php');
          ?>
            
        </div>
        <div class="main-bottom mt-4" id="about">
            <div class="about d-flex flex-column justify-content-center p-2">
                <?php require ('partials/main-about.php');
                ?>
            </div>
            <div class="clients">
                <?php require ('partials/main-clients.php');
                ?>
            </div>
        </div>
    </main>

    <footer>
        <?php require ('partials/footer-nav.php');
        ?>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>