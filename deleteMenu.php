<?php
        header('Content-Type: application/json');

        // Check if the request method is POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate and sanitize the menuId
            $menuId = filter_input(INPUT_POST, 'menuId', FILTER_VALIDATE_INT);
            
            if ($menuId !== false && $menuId > 0) {
                // Database connection details
                $server = "localhost";
                $username = "root";
                $password = "";
                $database = "PointOfSale";

                // Create a database connection
                $conn = new mysqli($server, $username, $password, $database);

                // Check the database connection
                if ($conn->connect_error) {
                    echo json_encode(['success' => false, 'message' => 'Database connection error']);
                    exit;
                }

                // Prepare and execute the DELETE query
                $sql = "DELETE FROM ref_menu WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $menuId);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Menu deleted successfully']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to delete menu']);
                }

                // Close the database connection
                $stmt->close();
                $conn->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Invalid menu ID']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request method']);
        }
?>
