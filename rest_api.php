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
?>