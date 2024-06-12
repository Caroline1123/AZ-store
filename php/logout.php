<?php

session_start();

if (isset($_POST["logout"])) {
    unset($_SESSION["user"]);
}



echo '

<form action="" method="POST">
<input type="hidden">
<button id="logout-button" type="submit">Logout</button>

</form>'


    ?>