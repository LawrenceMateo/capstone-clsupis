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

    if(isset($_POST['sector_name'])){
        $sector_name = trim($_POST['sector_name']);

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_sector_name = isAlpha($sector_name);

        if( !$valid_sector_name ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_sector_name )
            array_push( $response["data"]["message"], "Sector name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT sector_name FROM tbl_sectors WHERE sector_name = '$sector_name'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $sectorCount = mysqli_num_rows( $result );
    
                if( $sectorCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "Sector name already exists.";
                } else {
                    $response["data"]["isValidSector"] = true;
                    $sql = "INSERT INTO tbl_sectors (sector_name) VALUES ('$sector_name')";
            
                    if(mysqli_query($conn, $sql)){
                    
                        $response["data"]["message"] = "Sector added successfully. "; 
                    
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