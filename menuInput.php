<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Menu Input</title>
    <!-- Add Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Velayo POS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Menu</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1 class="text-center">Create Menu</h1>
        <form action="addMenu.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Menu Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
    <div class="container">
        <h1>Menu List</h1>
        <div class="mb-3">
            <input type="text" class="form-control" id="search" placeholder="Search by Name or ID">
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Menu Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody id="menuList">
                <?php
                $conn = new mysqli('localhost', 'root', '', 'pointofsale');

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT id, menu_name, menu_desc, price FROM ref_menu";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["menu_name"] . "</td>";
                        echo "<td>" . $row["menu_desc"] . "</td>";
                        echo "<td>" . $row["price"] . "</td>";
                        echo "<td><button class='btn btn-primary editBtn' data-id='" . $row["id"] . "'>Update</button> <button class='btn btn-danger deleteBtn' data-id='" . $row["id"] . "'>Delete</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No data found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Menu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateForm" action="updateMenu.php" method="post">
                        <input type="hidden" id="menuId" name="menuId">
                        <div class="mb-3">
                            <label for="updateName" class="form-label">Menu Name</label>
                            <input type="text" class="form-control" id="updateName" name="updateName" required>
                        </div>
                        <div class="mb-3">
                            <label for="updateDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="updateDescription" name="updateDescription" rows="5" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateMenu()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this menu?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" onclick="deleteMenu()">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Add SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const form = document.querySelector("form");
            form.addEventListener("submit", async function (e) {
                e.preventDefault();

                const nameInput = document.getElementById("name");
                const descriptionInput = document.getElementById("description");

                const name = nameInput.value.trim();
                const description = descriptionInput.value.trim();

                // Check character limits
                if (name.length > 100) {
                    Swal.fire({
                        icon: "error",
                        title: "Character Limit Exceeded",
                        text: "Menu Name should be 100 characters or less.",
                    });
                    return;
                }

                if (description.length > 1000) {
                    Swal.fire({
                        icon: "error",
                        title: "Character Limit Exceeded",
                        text: "Menu Description should be 1000 characters or less.",
                    });
                    return;
                }

                // Submit the form
                form.submit();
            });
        });

        function handleUpdateClick(menuId, name, description) {
            const updateForm = document.getElementById("updateForm");
            const updateName = document.getElementById("updateName");
            const updateDescription = document.getElementById("updateDescription");
            const menuIdInput = document.getElementById("menuId");

            menuIdInput.value = menuId;
            updateName.value = name;
            updateDescription.value = description;

            // Show the update modal
            new bootstrap.Modal(document.getElementById("updateModal")).show();
        }

        function handleDeleteClick(menuId) {
            const menuIdInput = document.getElementById("menuId");
            menuIdInput.value = menuId;

            new bootstrap.Modal(document.getElementById("deleteModal")).show();
        }

        async function updateMenu() {
            const menuIdInput = document.getElementById("menuId");
            const updateName = document.getElementById("updateName").value;
            const updateDescription = document.getElementById("updateDescription").value;

            const data = {
                menuId: menuIdInput.value,
                updateName: updateName,
                updateDescription: updateDescription
            };

            try {
                const response = await fetch('updateMenu.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        console.log("Menu updated successfully");
                        new bootstrap.Modal(document.getElementById("updateModal")).hide();
                    } else {
                        console.error("Error updating menu");
                    }
                } else {
                    console.error("Error updating menu");
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }

        async function deleteMenu() {
            const menuIdInput = document.getElementById("menuId");

            const data = {
                menuId: menuIdInput.value
            };

            try {
                const response = await fetch('deleteMenu.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (response.ok) {
                    const result = await response.json();
                    if (result.success) {
                        console.log("Menu deleted successfully");
                        new bootstrap.Modal(document.getElementById("deleteModal")).hide();
                    } else {
                        console.error("Error deleting menu");
                    }
                } else {
                    console.error("Error deleting menu");
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    </script>
</body>
</html>
