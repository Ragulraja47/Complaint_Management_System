<?php
$conn = new mysqli("localhost", "root", "", "complaints");
if ($conn->connect_error) {
    die("" . $conn->connect_error);
}
?>