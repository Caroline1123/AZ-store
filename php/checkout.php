<?php

session_start();
require_once ("./cart-functions.php");
require_once ("./form-validation.php");


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
    <h3 class="m-3 text-center">Your Details</h3>
    <form id="checkout-form" action="" method="POST">
        <div class="checkout border rounded d-flex m-3 p-4">
            <div class="overview d-flex flex-column">
                <div class="delivery-info">
                    <h5>Delivery details</h5>
                    <h6 class="my-3">Info</h6>
                    <div class="gender m-3">
                        <input type="radio" id="mr" name="drone" value="Mr" checked />
                        <label for="Mr">Mr</label>
                        <input type="radio" id="Mrs" name="drone" value="Mrs" />
                        <label for="Mrs">Mrs</label>
                        <input type="radio" id="other" name="drone" value="other" />
                        <label for="other">Other</label>
                    </div>
                    <input class="form-control mt-3" type="text" maxlength="50" name="first-name" id="first-name"
                        placeholder="First Name" required>
                    <!-- <?php ($first_name) ?> -->
                    <div class="error" id="first-name-error"></div>
                    <input class="form-control mt-3" type="text" maxlength="50" name="last-name" id="last-name"
                        placeholder="Last Name" required>
                    <div class="error" id="last-name-error"></div>
                    <h6 class="my-3">Contact</h6>
                    <div class="phone-nr input-group mt-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><img src="./../assets/images/phone.svg" alt="Phone"></span>
                        </div>
                        <input class="form-control" type="text" name="phone-nr" id="phone-nr" maxlength="13"
                            value="+32 " required>
                    </div>
                    <div class="error" id="phone-nr-error"></div>
                    <input class="form-control mt-3" type="email" name="email" id="email" placeholder="Email" required>
                    <div class="error" id="email-error"></div>
                    <h6 class="my-3">Address</h6>
                    <div class="alert alert-primary d-inline-block p-2 mt-3" role="alert">
                        Currently, we only offer shipping within Belgium.
                    </div>
                    <div class="input-group">
                        <input class="postcode form-control mt-3 me-4 rounded" type="number" id="postcode"
                            placeholder="Postcode" max="9999" required>
                        <input class="city form-control mt-3 rounded" type="text" name="city" id="city" maxlength="50"
                            placeholder="City" required>
                    </div>
                    <div class="error" id="city-error"></div>
                    <div class="input-group">
                        <input class="street form-control mt-3 me-4 rounded" type="text" name="street-name"
                            id="street-name" placeholder="Street Name" maxlength="100" required>
                        <input class="street-nr form-control mt-3 rounded" type="text" name="street-nr" id="street-nr"
                            placeholder=" Street Nr" maxlength="10" required>
                    </div>
                    <div class="error" id="street-name-error"></div>
                    <div class="error" id="street-nr-error"></div>
                    <h5 class="mb-4 mt-2 pt-3 border-top">Select a payment method</h5>
                    <div class="payment-methods d-flex flex-column">
                        <div class="bancontact d-flex alert-light alert p-2">
                            <input type="radio" name="method" value="" checked>
                            <label class="ps-4 fw-bold" for="method">Bancontact</label>
                            <span>
                                <img src="./../assets/images/bancontact.svg" alt="">
                            </span>
                        </div>
                        <div class="credit-card d-flex alert-light alert p-2">
                            <input type="radio" name="method" value="">
                            <label class="ps-4 fw-bold" for="method">Credit Card</label>
                            <span>
                                <img src="./../assets/images/visa.svg" alt="">
                                <img src="./../assets/images/mastercard.svg" alt="">
                            </span>
                        </div>
                        <div class="paypal d-flex alert-light alert p-2">
                            <input type="radio" name="method" value="">
                            <label class="ps-4 fw-bold" for="method">Paypal</label>
                            <span>
                                <img src="./../assets/images/paypal.svg" alt="">
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <?php echo display_summary() ?>
        </div>
    </form>
    <?php require 'partials/footer-nav.php' ?>
</body>