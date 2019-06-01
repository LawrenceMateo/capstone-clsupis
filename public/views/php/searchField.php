<?php
    
    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';

    $query = $_POST['search_field'];

    $sql = "SELECT * FROM tbl_field WHERE name LIKE '%$query%' ORDER BY name ASC";
    $result = mysqli_query($conn, $sql);

    $response = [];
    if($result){
        $response = array(
            "status" => 200,
            "error" => false,
            "data" => array(
                
            )
        );
        while($row = mysqli_fetch_assoc($result)){
            array_push($response['data'], $row);    
        }
        
    }

    echo json_encode($response);
?>