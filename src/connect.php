<?php

//archivo que es incluido cada vez que se quiera hacer una ca la base de datos
$host = "localhost";
$user = "root";
$password = "";
$database = "hotel";

$conn = new mysqli($host, $user, $password, $database); //intenta hacer la conexion a la base de datos


if ($conn->connect_error) {
    die("conexion fallida:" .  $conn->connect_error); // si sale mal, muestra cual es el error
}
?>