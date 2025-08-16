<?php
require '../config.php'; // Include the config file

// Create an instance of the Connection class
$connection = new Connection();
$conn = $connection->conn; // Access the database connection

// Check if the menu item ID is provided
if (!isset($_GET['id'])) {
    header("Location: manage_menu.php");
    exit();
}

$menu_id = $_GET['id'];

// Fetch the menu item details
$menu_query = "SELECT * FROM menu WHERE id = $menu_id";
$menu_result = $conn->query($menu_query);

if ($menu_result->num_rows === 0) {
    header("Location: manage_menu.php");
    exit();
}

$menu_item = $menu_result->fetch_assoc();

// Update menu item functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_menu_item'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $type = $_POST['type']; // Veg or Non-Veg
    $kcal = $_POST['kcal']; // Calories

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];

        // Save the new image to the images folder
        move_uploaded_file($image_tmp, "../images/$image");

        // Update the menu item with the new image
        $update_menu_query = "UPDATE menu SET name = '$name', price = '$price', type = '$type', kcal = '$kcal', image = './images/$image' WHERE id = $menu_id";
    } else {
        // Update the menu item without changing the image
        $update_menu_query = "UPDATE menu SET name = '$name', price = '$price', type = '$type', kcal = '$kcal' WHERE id = $menu_id";
    }

    $conn->query($update_menu_query);
    header("Location: manage_menu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Menu Item</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $menu_item['name']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="<?php echo $menu_item['price']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="veg" <?php echo $menu_item['type'] === 'veg' ? 'selected' : ''; ?>>Veg</option>
                    <option value="non-veg" <?php echo $menu_item['type'] === 'non-veg' ? 'selected' : ''; ?>>Non-Veg</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="kcal" class="form-label">Calories</label>
                <input type="text" class="form-control" id="kcal" name="kcal" value="<?php echo $menu_item['kcal']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image">
                <p class="mt-2">Current Image:</p>
                <img src="<?php echo $menu_item['image']; ?>" alt="<?php echo $menu_item['name']; ?>" width="100">
            </div>
            <button type="submit" name="update_menu_item" class="btn btn-primary">Update Item</button>
            <a href="manage_menu.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>