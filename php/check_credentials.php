<?php

// Array of registered users (username => pw)
$users = [
    "testUser" => "password1"
];

session_start();

// Check if user session is already active
if (isset($_POST["username"]) && !isset($_SESSION["username"])) {
    // Check if credentials entered match array of registered users
    if ($users[$_POST["username"]] == $_POST["password"]) {
        $_SESSION["username"] = $_POST["username"];
        echo "WOW ! You managed to login, testUser";
    }
    // If session not created, send error
    if (!isset($_SESSION["username"])) {
        $failed = true;
    }

    // Redirect user to index page if login is successful
    if (isset($_SESSION["username"])) {
        header("Location:index.php");
        exit();
    }
}
?>