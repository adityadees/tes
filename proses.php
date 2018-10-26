<?php
include "koneksi.php";
$nelat=$_POST['nelat'];
$nelng=$_POST['nelng'];
$swlat=$_POST['swlat'];
$swlng=$_POST['swlng'];
$ket=$_POST['ket'];

$query=mysqli_query($con,"INSERT INTO map (map_id,nelat,nelng,swlat,swlng,ket) VALUES ('','$nelat','$nelng','$swlat','$swlng','$ket')")  or die(mysqli_error($con))


?>