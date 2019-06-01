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

    if(isset($_POST['field_name'])){
        $field_name = trim($_POST['field_name']);

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_field_name = isAlpha($field_name);

        if( !$valid_field_name ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_field_name )
            array_push( $response["data"]["message"], "Field name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT name FROM tbl_field WHERE name = '$field_name'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $fieldCount = mysqli_num_rows( $result );
    
                if( $fieldCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "Field name already exists.";
                } else {
                    $response["data"]["isValidField"] = true;
                    $sql = "INSERT INTO tbl_field (name) VALUES ('$field_name')";
            
                    if(mysqli_query($conn, $sql)){
                    
                        $response["data"]["message"] = "Research field added successfully. "; 
                    
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
        $response["data"]["message"] = "All fields are required. ";
    }

    echo json_encode( $response );

?>