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
    
    if(isset($_POST['edit_field_name'])){
        $field_id = $_POST['edit_field_id'];
        $field_name = trim($_POST['edit_field_name']);
        
        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_field_name = isAlpha($field_name);

        if(!$valid_field_name){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_field_name )
            array_push( $response["data"]["message"], "Field name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $sql = "UPDATE tbl_field SET name = '$field_name' WHERE id = $field_id";
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