<?php 
session_start();

$host = "localhost";
$kullanici = "root";
$parola = "12345678";
$vt = "cevaplar";

$baglanti = mysqli_connect($host, $kullanici, $parola, $vt);

mysqli_set_charset($baglanti, "utf8");



// if ($baglanti){

// 	echo "Veritabanı ile etkileşime geçildi";
// }

 ?>