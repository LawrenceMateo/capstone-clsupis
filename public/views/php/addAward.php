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

    if( isset($_POST['award_name']) && isset($_POST['venue']) && isset($_POST['date_awarded']) && isset($_POST['given_by'])  ){
        $projectId = $_POST['award_project_id'];
        $awardName = $_POST['award_name'];
        $venue = $_POST['venue'];
        $dateAwarded = $_POST['date_awarded'];
        $awardedBy = $_POST['given_by'];

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $validAwardName = isAlpha($awardName);
        $validAwardedBy = isAlpha($awardedBy);

        if( !$validAwardedBy || !$validAwardName ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( !$validAwardedBy )
                array_push( $response["data"]["message"], "Award giving body must have letters only. " );
            if( !$validAwardName )
                array_push( $response["data"]["message"], "Award recieved must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT award_title FROM tbl_awards WHERE award_title = '$awardName' AND project_id = '$projectId'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $existingAwardCount = mysqli_num_rows( $result );
    
                if( $existingAwardCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "The project has already received this award.";
                } else {
                    $sql = "INSERT INTO tbl_awards (project_id, award_title, given_by, venue, date_awarded) VALUES ('$projectId', '$awardName', '$awardedBy', '$venue', '$dateAwarded')";
                    $sqlUpdateProject = "UPDATE tbl_projects SET has_award = 1 WHERE project_id = '$projectId'";
                    if( mysqli_query($conn, $sql) && mysqli_query($conn, $sqlUpdateProject) ){
                        $response["data"]["message"] = "Project award added successfully. "; 
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