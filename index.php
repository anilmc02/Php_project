<?php
include 'includes/db.php'; // Ensure this file sets up the $conn variable correctly

// SQL query to fetch student data along with class names
$query = "SELECT student.*, classes.name AS class_name 
          FROM student 
          JOIN classes ON student.class_id = classes.class_id";

// Execute the query and handle potential errors
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background: linear-gradient(45deg, #ff6b6b, #f7c6c7, #6b5b95, #ffb6b9);
        background-size: 400% 400%;
        animation: gradientAnimation 15s ease infinite;
    }

    @keyframes gradientAnimation {
        0% {
            background-position: 0% 0%;
        }
        50% {
            background-position: 100% 100%;
        }
        100% {
            background-position: 0% 0%;
        }
    }

    h1 {
        color: #333;
        text-align: center;
        margin-top: 20px;
    }

    a {
        color: #007bff; /* Bright blue for links */
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px auto;
        background: #fff; /* White background for table */
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #007bff; /* Blue header for contrast */
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9; /* Alternating row colors for better readability */
    }

    .message {
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
    }

    .success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
</style>


</head>
<body>
    <h1>Student List</h1>
    <a href="create.php">Add New Student</a>
    
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
        <div class="message success">
            Student successfully added!
        </div>
    <?php } ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Address</th>
            <th>Created At</th>
            <th>Class</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td><?php echo htmlspecialchars($row['class_name']); ?></td>
                <td>
                    <?php if ($row['image']) { ?>
                        <img src="uploads/<?php echo htmlspecialchars($row['image']); ?>" width="100">
                    <?php } else { ?>
                        No Image
                    <?php } ?>
                </td>
                <td>
                    <a href="view.php?id=<?php echo $row['id']; ?>">View</a>
                    <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
