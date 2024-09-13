<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 bg-light">
                <?php include 'sidebar.php'; ?>
            </div>

            <!-- Main Content -->
            <div class="col-md-10">
                <h2>Welcome, <?= $_SESSION['username'] ?></h2>
                <a href="add_project.php" class="btn btn-primary">Add Project</a>
                
                <!-- Display Project Details -->
                <div id="project-details">
                    <!-- Project details will be loaded dynamically when a project is clicked -->
                </div>
            </div>
        </div>
    </div>
</body>
</html>
