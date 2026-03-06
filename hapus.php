<?php
require_once 'auth.php';
require_admin();

include "koneksi.php";

if(isset($_GET["idBuku"])){
    $idBuku = $_GET["idBuku"];
    
    // Gunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($koneksi, "DELETE FROM buku WHERE idBuku = ?");
    mysqli_stmt_bind_param($stmt, "s", $idBuku);
    $qhapus = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if($qhapus){
        header("location:media.php?page=tampildata");
        exit();
    }else{
        header("location:media.php?page=tampildata&error=1");
        exit();
    }
} else {
    header("location:media.php?page=tampildata");
    exit();
}
?>