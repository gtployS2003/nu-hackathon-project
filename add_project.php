<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $projectName = $_POST['project_name'];
    $userId = $_SESSION['userId'];

    $conn = new PDO('mysql:host=localhost;dbname=project_db', 'root', '');
    $stmt = $conn->prepare("INSERT INTO projects (name, user_id) VALUES (:name, :user_id)");
    $stmt->execute(['name' => $projectName, 'user_id' => $userId]);

    header('Location: dashboard.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
</head>
<body>
    <h2>Add New Project</h2>
    <form method="POST">
        <input type="text" name="project_name" placeholder="Project Name" required><br>
        <button type="submit">Add Project</button>
    </form>
</body>
</html>
