<?php
    
    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';

    $sql = "SELECT researcher_id, tbl_projects.title AS project, fullname, gender, researcher_role, bachelor_degree, bachelor_university, master_degree, master_university, doctorate, doctorate_university FROM tbl_researchers JOIN tbl_projects ON tbl_researchers.project_id = tbl_projects.project_id ORDER BY project ASC";
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