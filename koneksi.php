<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "db_perpustakaan";
$port = 3307;

$koneksi = mysqli_connect($host, $user, $password, $db, $port);

if (!$koneksi) {
    echo "<h2 style='color:red; text-align: center'> Database tidak terkoneksi!</h2>";
}
?>