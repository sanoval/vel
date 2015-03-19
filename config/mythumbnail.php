<?php 
include "config.php";
connect_db();
 
$id = $_GET['KB'];
$hasil = mysql_query("SELECT foto FROM tbbarang WHERE kd_barang = '$id'") or die (mysql_error()); 
$data  = mysql_fetch_row($hasil);
$gambar = $data[0];
 
$proporsi = 1; // menampilkan gambar 100% dari ukuran aslinya  
     
$img = imagecreatefromstring($gambar); 
     
$width = imagesx($img); 
$height = imagesy($img); 
 
define("T_WIDTH", $width*$proporsi); 
define("T_HEIGHT", $width*$proporsi); 
 
 
   
$img_copy = imagecreatetruecolor(T_WIDTH, T_HEIGHT); 
 
imagecopyresized($img_copy, $img, 0, 0, 0, 0, T_WIDTH, T_HEIGHT, $width, $height); 
 
header("Content-type: image/jpeg"); 
imagejpeg($img_copy); 
 
?> 