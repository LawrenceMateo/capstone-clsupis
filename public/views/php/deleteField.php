<?php
    
    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';

    $field_id = $_POST['delete_field_id'];

    $sql = "DELETE FROM tbl_field WHERE id = $field_id";
    $result = mysqli_query($conn, $sql);

    $response = [];
    if($result){
        $response = array(
            "status" => 200,
            "error" => false,
            "data" => array(
                "message" => "Record deleted successfully."
            )
        );
    } else {
        $response = array(
            "status" => 200,
            "error" => true,
            "data" => array(
                "message" => "Error deleting record because: ".mysqli_error($conn)."."
            )
        );
    }

    echo json_encode($response);
?>