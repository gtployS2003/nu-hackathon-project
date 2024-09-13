<?php
session_start();
// include the configs / constants for the database connection
require_once("../config/config.php");
require_once("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $json = array(
        "IsSuccess" => false,
        "ErrorMessage" => "Invalid Request Method"
    );
}

$username = $_POST["username"];
$password = $_POST["password"];

if (!empty($username)
    && !empty($password)
)
{

            $username = $_POST["username"];
            $sqlContent = "SELECT
                        *
                    FROM user_account
                    where LOWER(username) = LOWER(:username)";
            $stmtContent = $conn->prepare($sqlContent);
            $stmtContent->execute(array(":username" => $username));

            $rowContent = $stmtContent->fetch();

            if ($rowContent == null)
            {           
                $_SESSION["username"] = $username;

                $json = array(
                    "IsSuccess" => true,
                    "Username" => $username,
                    "ErrorMessage" => "Request"
                );
            }
            else
            {
                // update the last access time on database
                $_SESSION["username"] = $username;
                $_SESSION["name"] = $rowContent["name"];
                $_SESSION["userId"] = $rowContent["id"];
                $_SESSION["userTypeId"] = $rowContent["user_type_id"];
                $_SESSION["is_main_screen"] = $rowContent["is_main_screen"];

                $sqlUpdate = "UPDATE user_account SET last_access_time=now() WHERE LOWER(username) = LOWER(:username)";
                $stmtUpdate = $conn->prepare($sqlUpdate);
                $stmtUpdate->execute(array(":username" => $username));

                if($rowContent["user_type_id"] == 1 || $rowContent["user_type_id"] == 2){
                    $json = array(
                        "IsSuccess" => true,
                        "ErrorMessage" => "Update The Last access time Complete",
                        "page" => "index"
                    );

                }
            }
    //     } 
    // }

} else {
    $json = array(
        "IsSuccess" => false,
        "ErrorMessage" => "โปรดระบุข้อมูลให้ครบถ้วน"
    );
}

/* Output header */
header('Content-type: application/json');
echo json_encode($json);

?>