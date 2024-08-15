<?php
include 'includes/db.php'; // Ensure this file sets up the $conn variable correctly

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Handle file upload
    $image = null;
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "uploads/" . basename($image);
        $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));

        // Validate file type
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (!in_array($imageFileType, $allowedTypes)) {
            die("Only JPG, JPEG, and PNG files are allowed.");
        }
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            die("Failed to upload image.");
        }
    }

    // Prepare and execute SQL query
    $query = "INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssis', $name, $email, $address, $class_id, $image);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?status=success');
        exit();
    } else {
        die("Failed to insert record: " . mysqli_error($conn));
    }
}

// Fetch classes for the dropdown
$query = "SELECT * FROM classes";
$classes = mysqli_query($conn, $query);

if (!$classes) {
    die("Failed to fetch classes: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link rel="stylesheet" href="styles.css">
    
</head>
<body>
    <h1>Create Student</h1>
    <form action="create.php" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" required>
        
        <label>Email:</label>
        <input type="email" name="email" required>
        
        <label>Address:</label>
        <textarea name="address"></textarea>
        
        <label>Class:</label>
        <select name="class_id" required>
            <?php while ($row = mysqli_fetch_assoc($classes)) { ?>
                <option value="<?php echo htmlspecialchars($row['class_id']); ?>"><?php echo htmlspecialchars($row['name']); ?></option>
            <?php } ?>
        </select>
        
        <label>Image:</label>
        <input type="file" name="image">
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>
