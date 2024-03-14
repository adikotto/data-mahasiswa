<?php
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "universitas";
$link = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

if (!$link) {
   die("Koneksi Error");
}
