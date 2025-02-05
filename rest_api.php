<?php 
    header("Content-Type: application/json");
    include('db.php');
    
    $method = $_SERVER["REQUEST_METHOD"];

    // To get the data of the Users.
    if($method == "GET"){
        if(isset($_GET["serial_number"])){
            $serialnumber = intval($_GET["serial_number"]);
            $sql = "SELECT * FROM `users` WHERE `serial_number` = '$serialnumber'";
            $result = mysqli_query($conn, $sql);
            if($row = mysqli_fetch_assoc($result)){
                echo json_encode(["status" => "success", "data" => $row]);
            }else{
                echo json_encode(["status" => "error", "User not found"]);
            }
        }
        else{
            $sql = "SELECT * FROM `users`";
            $result = mysqli_query($conn, $sql);
            $users = [];
            while($row = mysqli_fetch_assoc($result)){
                $users[] = $row;
            }
    
            echo json_encode(["status" => "success", "message" => "Users successfully created", "data" => $users]);
        }
    }

    // To add information about the user
    elseif($method == "POST"){
        $data = json_decode(file_get_contents("php://input"), true);
        $username = $data['username'];
        $email = $data['email'];
        $sql = "INSERT INTO `users` (`username`, `email`) VALUES ('$username', '$email')";
        if(mysqli_query($conn, $sql)){
            echo json_encode(["status" => "success", "message" =>"Users successfully added"]);
        }else{
            echo json_encode(["status" => "error", "message" => "Could not add users"]);
        }
    }

    // To Update information of the user
    elseif($method == "PUT"){
        $data = json_decode(file_get_contents("php://input"), true);
        $serialnumber = $data['serial_number'];
        $username = $data['username'];
        $email = $data['email'];
        $sql = "UPDATE `users` SET `username` = '$username', `email` = '$email' WHERE `serial_number` = '$serialnumber'";
        if(mysqli_query($conn, $sql)){
            echo json_encode(["status" => "success", "message" => "User successfully updated"]);
        }else{
            echo json_encode(["status" => "error", "message" => "User is not updated"]);
        }
    }

    // To delete a user
    elseif($method == "DELETE"){
        $data = json_decode(file_get_contents("php://input"), true);
        $serialnumber = $data['serial_number'];
        $sql = "DELETE FROM `users` WHERE `serial_number` = '$serialnumber'";
        if(mysqli_query($conn, $sql)){
            echo json_encode(["status" => "success", "message" => "User deleted"]);
        }else{
            echo json_encode(["status" => "error", "message" => "User not found"]);
        }
    }
?>