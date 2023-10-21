<?php
    header('Content-Type: application/json');

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "PointOfSale";

    $conn = new mysqli($server, $username, $password, $database);

    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Unable to connect to the database.']);
        exit;
    }

    if (isset($_POST['menuId'], $_POST['updateName'], $_POST['updateDescription'])) {
        $menuId = $_POST['menuId'];
        $updateName = $_POST['updateName'];
        $updateDescription = $_POST['updateDescription'];

        $sql = "UPDATE ref_menu SET menu_name = ?, menu_desc = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $updateName, $updateDescription, $menuId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Menu updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update menu.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data received.']);
    }

    $conn->close();
?>
