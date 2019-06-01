<?php
    
    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';

    $awardId = $_POST['award_id'];

    $sql = "SELECT tbl_awards.award_id, tbl_awards.project_id, tbl_awards.award_title, tbl_awards.given_by, tbl_awards.venue, tbl_awards.date_awarded, tbl_projects.title FROM tbl_awards JOIN tbl_projects ON tbl_awards.project_id = tbl_projects.project_id WHERE award_id = $awardId ORDER BY tbl_awards.award_title ASC";
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