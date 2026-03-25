<?php
$link=mysqli_connect("localhost","root","","gestion_ventes");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
  }
 // echo "Connected successfully";