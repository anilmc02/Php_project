<?php
include 'includes/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$id = $_GET['id'];

// Fetch student details
$query = "SELECT student.*, classes.name AS class_name FROM student 
          JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];

    // Handle file upload
    $image = $student['image']; // Keep old image by default
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

    // Update student data
    $query = "UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssisi', $name, $email, $address, $class_id, $image, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        header('Location: index.php?status=success');
        exit();
    } else {
        die("Failed to update record: " . mysqli_error($conn));
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
    <title>Edit Student</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Edit Student</h1>
    <form action="edit.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($student['name']); ?>" required>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($student['email']); ?>" required>
        
        <label>Address:</label>
        <textarea name="address"><?php echo htmlspecialchars($student['address']); ?></textarea>
        
        <label>Class:</label>
        <select name="class_id" required>
            <?php while ($row = mysqli_fetch_assoc($classes)) { ?>
                <option value="<?php echo htmlspecialchars($row['class_id']); ?>" <?php if ($row['class_id'] == $student['class_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($row['name']); ?>
                </option>
            <?php } ?>
        </select>
        
        <label>Image:</label>
        <input type="file" name="image">
        <?php if ($student['image']) { ?>
            <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" width="100" alt="Student Image">
        <?php } ?>
        
        <button type="submit">Submit</button>
    </form>
</body>
</html>
