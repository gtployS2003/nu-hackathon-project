<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
}

$conn = new PDO('mysql:host=localhost;dbname=project_db', 'root', '');
$stmt = $conn->prepare("SELECT * FROM projects WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['userId']]);

$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Projects</title>
</head>
<body>
    <h2>All Projects</h2>
    <ul>
        <?php foreach ($projects as $project): ?>
            <li><?= $project['name'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
