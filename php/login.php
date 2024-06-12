<?php

require "check_credentials.php";

if (isset($failed)) {
    echo "Invalid credentials";
}

echo "
<h2>
Enter username and password
</h2>

<form action='' method= 'POST'>

    <label for='username'>Username</label>
    <input id='username' name='username' type='text' required><br>

    <label for='password'>password</label>
    <input id='password' name='password' type='password' required><br>

    <button id='login-button' type='submit'>Log In</button>
</form>

";
?>