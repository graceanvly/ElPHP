<html>
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>PHP Menu Input</title>
    <!-- Add Bootstrap CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.js"></script>

 
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light ">
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
    <!-- Add Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoJtKh7z7lGz7fuP4F8nfdFvAOA6Gg/z6Y5J6XqqyGXYM2ntX5" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8FqFjcJ6pajs/rfdfs3SO+kD4Ck5BdPtF+to8xMp9Mvc9l84l+78+m696jLmfIjzj6t" crossorigin="anonymous"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector("form");
        form.addEventListener("submit", function (e) {
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
    </script>

  </body>
</html>