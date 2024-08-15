<?php
session_start();
session_unset();
session_destroy();
header("Location: /App/ConectionBD/Register&Login/Login.php");
exit();
?>
