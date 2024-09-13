<?php
session_start();
$homeActive = "active";
    include_once "./config/setting.php";
    include "./config/config.php";
    include "./config/db.php";
    include "./function/fn_common.php";
if (isset($_SESSION['userId'])) {
    header('Location: dashboard.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ตรวจสอบการล็อกอิน
    $username = $_POST['username'];
    $password = $_POST['password'];

    // เชื่อมต่อฐานข้อมูล
    $conn = new PDO('mysql:host=localhost;dbname=project_db', 'root', '');
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
    $stmt->execute(['username' => $username, 'password' => md5($password)]);

    $user = $stmt->fetch();
    if ($user) {
        $_SESSION['userId'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: dashboard.php');
    } else {
        $error = 'Invalid login';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
</body>
</html>
