<?php

    session_start();

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

    $addedBy = $_SESSION['id'];

    if(
        isset($_POST['project_title']) && 
        isset($_POST['sector_id']) &&
        isset($_POST['field_id']) &&
        isset($_POST['type_id']) &&
        isset($_POST['date_added']) &&
        isset($_POST['date_started']) &&
        isset($_POST['date_ended']) &&
        isset($_POST['commodities']) &&
        isset($_POST['description']) &&
        isset($_POST['agency_id']) &&
        isset($_POST['funding'])
    ){
        $sectorId = $_POST['sector_id'];
        $fieldId = $_POST['field_id'];
        $typeId = $_POST['type_id'];
        $agencyId = $_POST['agency_id']; 
        $dateAdded = $_POST['date_added'];
        $dateStarted = $_POST['date_started'];
        $dateEnded = $_POST['date_ended']; 
        $projectTitle = trim($_POST['project_title']);
        $commodities = trim($_POST['commodities']);
        $description = trim($_POST['description']);
        $funding = trim($_POST['funding']);

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $validProjectTitle = isAlpha($projectTitle);
        $validFunding = isNumeric($funding);

        if( 
            !$validProjectTitle ||
            !$validFunding    
         ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( !$validProjectTitle )
                array_push( $response["data"]["message"], "Project title must contain letters only. " );
            if( !$validFunding )
                array_push( $response["data"]["message"], "Funding must contain numbers only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT title FROM tbl_projects WHERE title = '$projectTitle'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $projectCount = mysqli_num_rows( $result );
    
                if( $projectCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "Project already exists.";
                } else {
                    $response["data"]["isValidProject"] = true;

                    // INSERT PROJECT DATA
                    $sqlProject = "INSERT INTO tbl_projects (title, field_id, sector_id, type_id, date_added, date_started, date_ended, commodities, project_description, agency_id, approved_funding, added_by) VALUES ('$projectTitle', $fieldId, $sectorId, $typeId, '$dateAdded', '$dateStarted', '$dateEnded', '$commodities', '$description', $agencyId, $funding, '$addedBy')";

                    if(mysqli_query($conn, $sqlProject)){
                        $response["data"]["message"] = "Project profile added successfully. "; 
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