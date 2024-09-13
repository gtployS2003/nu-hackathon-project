<?php
$conn = new PDO('mysql:host=localhost;dbname=project_db', 'root', '');
$stmt = $conn->prepare("SELECT * FROM projects WHERE user_id = :user_id");
$stmt->execute(['user_id' => $_SESSION['userId']]);

$projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h3>Your Projects</h3>
<ul>
    <?php foreach ($projects as $project): ?>
        <li><a href="dashboard.php?project_id=<?= $project['id'] ?>"><?= $project['name'] ?></a></li>
    <?php endforeach; ?>
</ul>
