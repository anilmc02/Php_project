<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    
    $query = "INSERT INTO classes (name) VALUES (?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $name);
    mysqli_stmt_execute($stmt);
    
    header('Location: classes.php');
    exit();
}

if (isset($_GET['delete'])) {
    $class_id = $_GET['delete'];
    
    $query = "DELETE FROM classes WHERE class_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $class_id);
    mysqli_stmt_execute($stmt);
    
    header('Location: classes.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit'])) {
    $class_id = $_POST['class_id'];
    $name = $_POST['name'];
    
    $query = "UPDATE classes SET name = ? WHERE class_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $name, $class_id);
    mysqli_stmt_execute($stmt);
    
    header('Location: classes.php');
    exit();
}

$query = "SELECT * FROM classes";
$classes = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Manage Classes</h1>
    <form action="classes.php" method="post">
        <label>New Class Name:</label>
        <input type="text" name="name" required>
        <button type="submit">Add Class</button>
    </form>
    <h2>Existing Classes</h2>
    <table>
        <tr>
            <th>Class Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($classes)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td>
                    <a href="classes.php?delete=<?php echo $row['class_id']; ?>">Delete</a>
                    <a href="edit_class.php?id=<?php echo $row['class_id']; ?>">Edit</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
