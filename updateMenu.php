<?php
    header('Content-Type: application/json');

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "pointofsale";

    $conn = new mysqli($server, $username, $password, $database);

        if ($conn->connect_error) {
            echo json_encode(['status' => 'error', 'message' => 'Unable to connect to the database.']);
            exit;
        }

            if(isset($_POST['update_id']) && $_POST['update_id'] != '') {
                $id = $_POST['update_id'];
                $update_menu_name = $_POST['update_menu_name'];
                $update_menu_desc = $_POST['update_menu_desc'];
                $update_price = $_POST['update_price'];

                $sql = "UPDATE ref_menu SET menu_name = ?, menu_desc = ?, price = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdi", $update_menu_name, $update_menu_desc, $update_price, $id);
                
                    if($stmt->execute()) {
                        echo json_encode(['status' => 'success', 'message' => 'Menu updated successfully!']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Failed to update menu.']);
                    }
                    } else {
                        echo json_encode(['status' => 'error', 'message' => 'Invalid ID or Data.']);
                    }

    $conn->close();
?>