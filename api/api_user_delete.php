<?php
include "../config/config.php";
include "../config/db.php";
header('Content-type: application/json');

if(isset($_POST['id'])) {
    $id = $_POST['id'];
    try{
        $sql = $conn->prepare("DELETE FROM user_account WHERE id =:id");
        $sql->bindParam(':id', $id);
        $sql->execute();
        $data['IsSuccess'] = true;
        echo json_encode($data);
    }catch(PDOException $e){
        $data['IsSuccess'] = false;
        $data['ErrorMessage'] = $e;
        echo json_encode($data);
    }
}
else{
    $data['IsSuccess'] = false;
    echo json_encode($data);
}
?>