<?php
// ?----------------------------------Connection----------------------------------
include("connection.php");


print_r($_POST);
$nim = htmlentities(strip_tags(trim($_POST["nim"])));
$nim = mysqli_real_escape_string($link, $nim);
// ?----------------------------------Select----------------------------------
$query = "DELETE FROM mahasiswa where nim = $nim";
$result = mysqli_query($link, $query);
$affect = mysqli_affected_rows($link);

if ($result) {
   header("Location: data_mahasiswa.php");
}
