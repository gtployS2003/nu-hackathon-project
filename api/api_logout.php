<?php

session_start();
// $_SESSION["id"] = null;
// $_SESSION["username"] = null;
// $_SESSION["password"] = null;
session_destroy();

$result = new stdClass();
$result->IsSuccess = true;
header('Content-type: application/json');
echo json_encode($result);

?>