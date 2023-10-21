<?php
$mysqli = new mysqli("localhost", "root", "", "PointOfSale");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$menuId = $_POST["menuId"];

$query = "DELETE FROM ref_menu WHERE menu_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $menuId);

if ($stmt->execute()) {
    echo "Menu deleted successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
