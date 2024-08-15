<?php
include 'includes/db.php';

$id = $_GET['id'];

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    $query = "SELECT image FROM student WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);
    
    if ($student['image']) {
        unlink('uploads/' . $student['image']);
    }

    $query = "DELETE FROM student WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Student</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #333;
        }
        p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            margin: 5px;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 4px;
            font-size: 1em;
        }
        a:hover {
            background-color: #0056b3;
        }
        .cancel {
            background-color: #6c757d;
        }
        .cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Delete Student</h1>
        <p>Are you sure you want to delete this student?</p>
        <a href="delete.php?id=<?php echo $id; ?>&confirm=yes">Yes</a>
        <a href="index.php" class="cancel">No</a>
    </div>
</body>
</html>
