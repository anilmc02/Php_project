<?php
include 'includes/db.php';

$id = $_GET['id'];
$query = "SELECT student.*, classes.name AS class_name FROM student 
          JOIN classes ON student.class_id = classes.class_id WHERE student.id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$student = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('cinematic-bg.avif') no-repeat center center fixed;
            background-size: cover;
            overflow: hidden;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
            position: relative;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5); /* Dark overlay for cinematic effect */
            z-index: 1;
        }

        .container {
            width: 600px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
            z-index: 2;
            padding: 20px;
            margin: 0 auto;
            backdrop-filter: blur(5px);
        }

        .details h1 {
            margin-top: 0;
            color: #ffcc00;
            font-size: 24px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7); /* Highlight text */
        }

        .details p {
            font-size: 1.1em;
            margin: 10px 0;
        }

        .details strong {
            color: #ffcc00; /* Highlighted labels */
        }

        .student-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            position: absolute;
            top: 20px;
            right: 20px;
            border: 2px solid #ffcc00;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 1em;
            color: #fff;
            background-color: #ffcc00;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            margin-top: 20px;
            display: block;
            text-align: center;
        }

        .button:hover {
            background-color: #e6b800;
        }
    </style>
</head>
<body>  
<div class="waving-background"></div>
<div class="overlay"></div>
    <div class="container">
        <div class="details">
            <h1>Student Details</h1>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($student['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($student['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($student['address']); ?></p>
            <p><strong>Class:</strong> <?php echo htmlspecialchars($student['class_name']); ?></p>
            <p><strong>Created At:</strong> <?php echo htmlspecialchars($student['created_at']); ?></p>
            <?php if ($student['image']) { ?>
                <img src="uploads/<?php echo htmlspecialchars($student['image']); ?>" alt="Student Image" class="student-image">
            <?php } else { ?>
                <p>No Image Available</p>
            <?php } ?>
            <a href="index.php" class="button">Back to List</a>
        </div>
    </div>
</body>
</html>
