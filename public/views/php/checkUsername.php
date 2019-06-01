<?php
    // Init response obj
    $response = array(
        "error" => false,
        "data" => array(
            "message" => ""
        )
    );
    
    if( isset( $_POST["username"] ) ) {        
        $username = trim( $_POST["username"] );
        if( strlen( $username ) < 1 ) {
            $response["error"] = true;
            $response["data"]["message"] = "Username is required.";
        } else {            
            // Connect to db
            include "../../includes/connect_db.php";
            
            $sql = "SELECT username FROM tbl_users WHERE username = '$username'";
            if( $result = mysqli_query( $conn, $sql ) ) {
                $usernameCount = mysqli_num_rows( $result );
    
                if( $usernameCount > 0 ){
                    $response["data"]["isValidUsername"] = false;
                    $response["data"]["message"] = "Username is already taken.";
                } else {
                    $response["data"]["isValidUsername"] = true;
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
        $response["data"]["message"] = "Username is required.";
    }

    echo json_encode( $response );

?>