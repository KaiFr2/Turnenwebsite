<?php 
session_start();

$conn =  mysqli_connect("localhost", "root", "", "turnen");

if (!$conn) {
    die("Could not connect to server. Error: " . mysqli_connect_error());
}
?>