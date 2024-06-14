<?php
require_once ("cart-functions.php");
?>

<nav class="navbar navbar-expand-lg navbar-dark d-flex justify-content-between">
        <h1 class="az-store ms-3" href="#">AZ[store]</h1>
        <div class="container-fluid ">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center position-absolute top-50 start-50 translate-middle"
                        id="navbarNavAltMarkup">
                        <div class="navbar-nav">
                                <a class="nav-link active px-2" aria-current="page" href="index.php">Home</a>
                                <a class="nav-link px-2" href="index.php#about">About</a>
                                <a class="nav-link px-2" href="products.php">Products</a>
                                <a class="nav-link px-2" href="index.php#content">Content</a>
                        </div>
                </div>
        </div>
        <div class="cart mx-3 position-relative">
                <a class="nav-link" href="shopping-cart.php"><i class="fa-solid fa-cart-shopping"></i></a>
                <div id="cartQuantity">
                        <span class="quantity-display position-absolute rounded-circle"><?php echo show_quantity(); ?></span>
                </div>
        </div>
        <div class="login">
                <a class="nav-link me-3" href="#">Login</a>
        </div>
</nav>