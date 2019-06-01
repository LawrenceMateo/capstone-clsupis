<?php
    // Init response obj
    $response = array(
        "error" => false,
        "data" => array(
            "message" => ""
        )
    );
    
    if( isset( $_POST["email"] ) ) {        
        $email = trim( $_POST["email"] );
        if( strlen( $email ) < 1 ) {
            $response["error"] = true;
            $response["data"]["message"] = "Email is required.";
        } else {            
            // Connect to db
            include "../../includes/connect_db.php";
            
            $sql = "SELECT email FROM tbl_users WHERE email = '$email'";
            if( $result = mysqli_query( $conn, $sql ) ) {
                $emailCount = mysqli_num_rows( $result );
    
                if( $emailCount > 0 ){
                    $response["data"]["isValidEmail"] = false;
                    $response["data"]["message"] = "Email is already taken.";
                } else {
                    $response["data"]["isValidEmail"] = true;
                }
    
                mysqli_free_result( $result );
            } else {
                $response["error"] = true;
                $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
            }
    
            // Close db
            mysqli_close( $conn );
        }        
    } else {
        $response["error"] = true;
        $response["data"]["message"] = "Email is required.";
    }

    echo json_encode( $response );
?>