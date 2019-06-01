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
    
    if(isset($_POST['edit_sector_name'])){
        $sector_id = $_POST['edit_sector_id'];
        $sector_name = trim($_POST['edit_sector_name']);
        
        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $valid_sector_name = isAlpha($sector_name);

        if(!$valid_sector_name){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( ! $valid_sector_name )
            array_push( $response["data"]["message"], "Sector name must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $sql = "UPDATE tbl_sectors SET sector_name = '$sector_name' WHERE sector_id = $sector_id";
            $result = mysqli_query($conn, $sql);

            if($result){
                $response['data']['message'] = "Sector updated successfully.";
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