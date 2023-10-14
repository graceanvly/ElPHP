<?php
$mysqli = new mysqli("localhost", "root", "", "PointOfSale");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$menuName = $_POST["name"];
$menuDescription = $_POST["description"];


$query = "INSERT INTO ref_menu (menu_name, menu_desc) VALUES (?, ?)";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ss", $menuName, $menuDescription);

if ($stmt->execute()) {
    echo "Menu added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
