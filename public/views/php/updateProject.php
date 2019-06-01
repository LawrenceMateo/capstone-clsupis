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

    if( 
        
        isset($_POST['edit_project_title']) && 
        isset($_POST['edit_date_added']) &&
        isset($_POST['edit_date_started']) &&
        isset($_POST['edit_date_ended']) &&
        isset($_POST['edit_commodities']) &&
        isset($_POST['edit_description']) &&
        isset($_POST['edit_funding'])

        ){
        
            
        $projectId = $_POST['edit_project_id'];
        $projectTitle = $_POST['edit_project_title'];
        $sectorId = $_POST['edit_sector_id'];
        $fieldId = $_POST['edit_field_id'];
        $typeId = $_POST['edit_type_id'];
        $dateAdded = $_POST['edit_date_added'];
        $dateStarted = $_POST['edit_date_started'];
        $dateEnded = $_POST['edit_date_ended'];
        $commodities = $_POST['edit_commodities'];
        $description = $_POST['edit_description'];
        $agencyId = $_POST['edit_agency_id'];
        $funding = $_POST['edit_funding'];


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

            $sql = "UPDATE tbl_projects SET title = '$projectTitle', sector_id = '$sectorId', field_id = '$fieldId', type_id = '$typeId', date_added = '$dateAdded', date_started = '$dateStarted', date_ended = '$dateEnded', commodities = '$commodities', project_description = '$description', agency_id = '$agencyId', approved_funding = '$funding' WHERE project_id = $projectId";
            
            $result = mysqli_query($conn, $sql);

            if($result){
                $response['data']['message'] = "Record updated successfully.";
            } else {
                $response['error'] = true;
                $response['data']['message'] = "Error: " . mysqli_error( $conn ) . ".";
            }

        }

    } else {
        $response["error"] = true;
        $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
    }

    echo json_encode( $response );

?>