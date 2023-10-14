
<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the menu name and description from the form
    $menuName = $_POST["name"];
    $menuDesc = $_POST["description"];

    // Connect to the database
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPassword = "";
    $dbName = "PointOfSale"; // Change to your actual database name

    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check the database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert data into the database
    $sql = "INSERT INTO ref_menu (menu_name, menu_desc) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $menuName, $menuDesc);

    if ($stmt->execute()) {
        // Data insertion was successful
        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Menu added to the database',
                    icon: 'success',
                }).then(function () {
                    window.location.href = 'your_original_page.html'; // Redirect to your original page
                });
              </script>";
    } else {
        // Data insertion failed
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to add menu to the database',
                    icon: 'error',
                });
              </script>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
