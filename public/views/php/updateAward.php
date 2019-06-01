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
    
    if( isset($_POST['edit_award_name']) && isset($_POST['edit_given_by']) && isset($_POST['edit_date_awarded']) && isset($_POST['edit_venue']) ){
        
        $awardId = $_POST['edit_award_id'];
        $awardTitle = trim($_POST['edit_award_name']);
        $givenBy = trim($_POST['edit_given_by']);
        $dateAwarded = $_POST['edit_date_awarded'];
        $venue = $_POST['edit_venue'];
        
        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $validAwardTitle = isAlpha($awardTitle);
        $validGivenBy = isAlpha($givenBy);

        if( !$validAwardTitle || !$validGivenBy ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( !$validAwardTitle )
                array_push( $response["data"]["message"], "Award received must have letters only. " );
            if( !$validGivenBy )
                array_push( $response["data"]["message"], "Award givinig body must have letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $sql = "UPDATE tbl_awards SET award_title = '$awardTitle', given_by = '$givenBy', date_awarded = '$dateAwarded', venue = '$venue' WHERE award_id = $awardId";
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

    echo json_encode($response);
?>