<?php
session_start();
unset ($_SESSION['autorizado']);
unset ($_SESSION['nombreSESION']);
unset ($_SESSION['sesionID']);
session_destroy();
header ("location: index.php");
?>