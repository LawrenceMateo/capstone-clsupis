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
    
    if(isset($_POST['edit_agency_name']) && isset($_POST['edit_agency_address']) && isset($_POST['edit_agency_id'])){
        $agency_id = $_POST['edit_agency_id'];
        $agency_name = trim($_POST['edit_agency_name']);
        $agency_address = trim($_POST['edit_agency_address']);
        
        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_agency_name = isAlpha($agency_name);

        if(!$valid_agency_name){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_agency_name )
            array_push( $response["data"]["message"], "Agency name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $sql = "UPDATE tbl_agencies SET agency_name = '$agency_name', address = '$agency_address' WHERE agency_id = $agency_id";
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