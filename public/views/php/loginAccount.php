<?php
    // Init response obj
    $response = array(
        "error" => false,
        "data" => array(
            "message" => ""
        )
    );

    if( 
        isset( $_POST["login_email"] ) &&
        isset( $_POST["login_password"] )
    ) {
        $email = trim( $_POST["login_email"] );
        $password = trim( $_POST["login_password"] );
        
        // Connect to db
        include "../../includes/connect_db.php";

        $sql = "SELECT * FROM tbl_users WHERE email='$email'";
        if( $result = mysqli_query( $conn, $sql ) ) {
            if( $row = mysqli_fetch_assoc( $result ) ) {
                if( !password_verify( $password, $row["password"] ) ) {
                    $response["error"] = true;
                    $response["data"]["message"] = "Password is incorrect. ";
                } else {
                    $userId = $row["id"];
                    $username = $row["username"];
                    $userType = $row["usertype"];
                    $contact_number = $row["contact_number"];
                    $fullName = $row['firstname']." ".$row['lastname'];
                    $response["data"]["message"] = 'Account is successfully logged in. ';             
                    session_start();
                    $_SESSION['id'] = $userId;
                    $_SESSION['username'] = $username;
                    $_SESSION['fullName'] = $fullName;
                    $_SESSION['email'] = $email;
                    $_SESSION['userType'] = $userType;
                }
            } else {
                $response["error"] = true;
                $response["data"]["message"] = 'Account does not exist. ';
            }

        } else {
            $response["error"] = true;
            $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
        }

        // Close db
        mysqli_close( $conn );
    } else {
        $response["error"] = true;
        $response["data"]["message"] = 'All fields are required. ';
    }

    echo json_encode( $response );
?>