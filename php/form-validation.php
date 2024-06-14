<?php

require_once ("./cart-functions.php");

function sanitize_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function validate_form()
{
    $response = [
        'valid' => true,
        'errors' => []
    ];

    if (empty(sanitize_input($_POST['first-name']))) {
        $response['valid'] = false;
        $response['errors']['first-name'] = "First name is required.";
    }

    if (empty(sanitize_input($_POST['last-name']))) {
        $response['valid'] = false;
        $response['errors']['last-name'] = "Last name is required.";
    }

    if (empty(sanitize_input($_POST['phone-nr']))) {
        $response['valid'] = false;
        $response['errors']['phone-nr'] = "Phone number is required.";
    }

    if (empty(sanitize_input($_POST['email']))) {
        $response['valid'] = false;
        $response['errors']['email'] = "Email is required.";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $response['valid'] = false;
        $response['errors']['email'] = "Invalid email format.";
    }

    if (empty(sanitize_input($_POST['city']))) {
        $response['valid'] = false;
        $response['errors']['city'] = "City is required.";
    }

    if (empty(sanitize_input($_POST['street-name']))) {
        $response['valid'] = false;
        $response['errors']['street-name'] = "Street name is required.";
    }

    if (empty(sanitize_input($_POST['street-nr']))) {
        $response['valid'] = false;
        $response['errors']['street-nr'] = "Street number is required.";
    }
    return $response;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $response = validate_form();
    if ($response['valid']) {
        clear_cart();
        $_SESSION['order_success'] = true;
        echo json_encode([
            'success' => true,
            'redirect' => 'index.php'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'errors' => $response['errors']
        ]);
    }
    exit();
}

?>