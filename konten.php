<?php
require_once 'auth.php';
require_login();

if (isset($_GET["page"])){
    $page = $_GET["page"];
    if (file_exists("$page.php")){
        include "$page.php";
    }else{
        echo "<h3 align='center'> Halaman Tidak Ditemukan </h3>";
    }
}else{
    include "home.php";
}
?>