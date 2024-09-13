<?php
session_start();
require_once("../config/config.php");
require_once("../config/db.php");
header('Content-type: application/json');

$username = isset($_POST["username"]) ? $_POST["username"] : "";
$name = $_POST["name"];
$userId = isset($_POST["userId"]) ? $_POST["userId"] : "";
$userTypeId  = isset($_POST["userType"]) ? $_POST["userType"] : 1;
$isMainScreen = $_POST["isMainScreen"];

$userScreens = isset($_POST["userScreens"]) ? $_POST["userScreens"] : null;

$mainScreen = $isMainScreen == "true" ? 1:0;

$isEdit = $userId != null;
// $data['message'] = $_POST;
// echo json_encode($data);

try {
    if(!$isEdit){
        $sqlContent = "SELECT
                        *
                    FROM user_account
                    WHERE LOWER(username) = LOWER(:username)";
        $stmtContent = $conn->prepare($sqlContent);
        $stmtContent->bindParam(':username', $username);
        $stmtContent->execute();
        
        $rowContent = $stmtContent->fetch();
        if ($rowContent == null){
                $_SESSION["userTypeId"] = $userTypeId;
                $_SESSION["username"] = $username;
                $_SESSION["name"] = $name;
                $_SESSION["is_main_screen"] = $mainScreen;
                
                // update the account on database
                $sql = $conn->prepare("INSERT INTO user_account (
                                                user_type_id,
                                                username,
                                                name,
                                                is_main_screen,
                                                last_access_time
                                                ) 
                                                VALUES (
                                                :user_type_id,
                                                :username,
                                                :name,
                                                :is_main_screen,
                                                now()
                                                )");
                $sql->bindParam(':user_type_id', $userTypeId);
                $sql->bindParam(':username', $username);
                $sql->bindParam(':name', $name);
                $sql->bindParam(':is_main_screen', $mainScreen);
                $sql->execute();
    
                $last_id = $conn->lastInsertId();
                $_SESSION["userId"] = $last_id;

                
                $data['IsSuccess'] = true;
                echo json_encode($data);

        }else {
            $data['IsSuccess'] = false;
            $data['ErrorMessage'] = "โปรดระบุข้อมูลให้ครบถ้วน";
            echo json_encode($data);
        }
    }else {
        $sql = $conn->prepare("UPDATE user_account SET user_type_id=:user_type_id, name=:name, is_main_screen=:is_main_screen, last_update=now() WHERE id=:id");
        $sql->bindParam(':id', $userId);
        $sql->bindParam(':user_type_id', $userTypeId);
        $sql->bindParam(':name', $name);
        $sql->bindParam(':is_main_screen', $mainScreen);
        $sql->execute();
        
        // Update >> Clear user_channel
        $sql2 = $conn->prepare("DELETE FROM user_permission WHERE user_account_id=:user_account_id");
        $sql2->bindParam(':user_account_id', $userId);
        $sql2->execute();

        if ($userScreens != null){
            foreach ($userScreens as $userScreen) {
                $pageId = $userScreen["id"];
                $sql3 = $conn->prepare("INSERT INTO user_permission (
                                                user_account_id,
                                                page_id,
                                                last_update
                                                ) 
                                                VALUES (
                                                :user_account_id,
                                                :page_id,
                                                now()
                                                )");
                $sql3->bindParam(':user_account_id', $userId);
                $sql3->bindParam(':page_id', $pageId);
                $sql3->execute();
            }
        }


        $data['IsSuccess'] = true;
        echo json_encode($data);
    }


} catch (PDOException $e) {
    $data['IsSuccess'] = false;
    $data['ErrorMessage'] = $e;
    echo json_encode($data);
}

?>