<?php 
$host = 'localhost';
$pass = '';
$user = 'root';
$db = 'moda';

$conn = mysqli_connect($host,$user,$pass,$db);

if (!$conn) {
    die("Falha na conexão: ". mysqli_connect_error());
}

mysqli_set_charset($conn, 'utf8');
?>