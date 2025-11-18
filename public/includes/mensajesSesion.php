<?php
session_start();
if (isset($_SESSION['error'])) {
    echo "<div class='error'>{$_SESSION['error']}</div>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['exito'])) {
    echo "<div class='exito'>{$_SESSION['exito']}</div>";
    unset($_SESSION['exito']);
}
if (isset($_SESSION['estado'])) {
    echo "<div class='estado'>{$_SESSION['estado']}</div>";
    unset($_SESSION['estado']);
}
?>