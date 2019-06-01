<?php

    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    $response = array(
        "error" => false,
        "data" => array(
            "message" => ""
        )
    );

    if(isset($_POST['type_name'])){
        $type_name = trim($_POST['type_name']);

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_type_name = isAlpha($type_name);

        if( !$valid_type_name ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_type_name )
            array_push( $response["data"]["message"], "Reseach type name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT type_name FROM tbl_project_type WHERE type_name = '$type_name'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $typeCount = mysqli_num_rows( $result );
    
                if( $typeCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "Research type name already exists.";
                } else {
                    $response["data"]["isValidType"] = true;
                    $sql = "INSERT INTO tbl_project_type (type_name) VALUES ('$type_name')";
            
                    if(mysqli_query($conn, $sql)){
                    
                        $response["data"]["message"] = "Research type added successfully. "; 
                    
                    } else { 

                        $response["error"] = true;
                        $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
                    
                    }
                }
    
                mysqli_free_result( $result );
            } else {
                $response["error"] = true;
                $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
            }

            // CLOSE DB
            mysqli_close( $conn );
        }
    } else {
        $response["error"] = true;
        $response["data"]["message"] = "All types are required. ";
    }

    echo json_encode( $response );

?>