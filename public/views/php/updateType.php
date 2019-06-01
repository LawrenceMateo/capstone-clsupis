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
    
    if(isset($_POST['edit_type_name'])){
        $type_id = $_POST['edit_type_id'];
        $type_name = trim($_POST['edit_type_name']);
        
        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_type_name = isAlpha($type_name);

        if(!$valid_type_name){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_type_name )
            array_push( $response["data"]["message"], "Research type name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $sql = "UPDATE tbl_project_type SET type_name = '$type_name' WHERE type_id = $type_id";
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