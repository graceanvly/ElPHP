<?php
    header('Content-Type: application/json');

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "PointOfSale";

    $conn = new mysqli($server, $username, $password, $database);

        if ($conn->connect_error) {
            echo json_encode(['status' => 'error', 'message' => 'Unable to connect to the database.']);
            exit;
        }

        if(isset($_POST['id']) && $_POST['id'] != '') {
            $id = $_POST['id'];

                $sql = "DELETE FROM ref_menu WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $id);

            if($stmt->execute()) {
                echo json_encode(['status' => 'success']);
                 } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete menu.']);
            }
                     } else {
                     echo json_encode(['status' => 'error', 'message' => 'Invalid ID.']);
                    }

    $conn->close();
?>
