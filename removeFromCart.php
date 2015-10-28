<?php
session_start();
include ('include/config.php');

unset($_SESSION['cartTVAmNet'][$_GET['ID']]); 
header('Location: carrito.php');
?>