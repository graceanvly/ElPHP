<?php
$mysqli = new mysqli("localhost", "root", "", "PointOfSale");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$menuId = $_POST["menuId"];
$updateName = $_POST["updateName"];
$updateDescription = $_POST["updateDescription"];

$query = "UPDATE ref_menu SET menu_name = ?, menu_desc = ? WHERE menu_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("ssi", $updateName, $updateDescription, $menuId);

if ($stmt->execute()) {
    echo "Menu updated successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$mysqli->close();
?>
