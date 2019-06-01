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

    if(isset($_POST['agency_name']) && isset($_POST['agency_address'])){
        $agency_name = trim($_POST['agency_name']);
        $agency_address = trim($_POST['agency_address']);

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_agency_name = isAlpha($agency_name);

        if( !$valid_agency_name ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_agency_name )
            array_push( $response["data"]["message"], "Agency name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT agency_name FROM tbl_agencies WHERE agency_name = '$agency_name'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $agencyCount = mysqli_num_rows( $result );
    
                if( $agencyCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "Record name already exists.";
                } else {
                    $response["data"]["isValidAgency"] = true;
                    $sql = "INSERT INTO tbl_agencies (agency_name, address) VALUES ('$agency_name', '$agency_address')";
            
                    if(mysqli_query($conn, $sql)){
                    
                        $response["data"]["message"] = "Funding agency added successfully. "; 
                    
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