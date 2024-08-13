<?php
session_start();

// Alternar el modo oscuro
if (isset($_GET['toggle_dark_mode'])) {
    if (isset($_SESSION['dark_mode'])) {
        unset($_SESSION['dark_mode']);
    } else {
        $_SESSION['dark_mode'] = true;
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$dark_mode = isset($_SESSION['dark_mode']);
?>