<?php
    
    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';
    session_start();
    $addedBy = $_SESSION['id'];

        $sql = "SELECT tbl_projects.project_id, tbl_projects.title, tbl_projects.field_id, tbl_projects.sector_id, tbl_projects.type_id, tbl_projects.agency_id, tbl_field.name AS fieldName, tbl_sectors.sector_name AS sectorName, tbl_project_type.type_name AS typeName, date_added, date_started, date_ended, commodities, project_description, tbl_agencies.agency_name AS agencyName, tbl_agencies.address AS agencyAddress, approved_funding, is_published, has_award, tbl_researchers.fullname, tbl_researchers.researcher_role AS role, tbl_researchers.bachelor_degree, tbl_researchers.bachelor_university, tbl_researchers.master_degree, tbl_researchers.master_university, tbl_researchers.doctorate, tbl_researchers.doctorate_university, tbl_awards.award_title AS award FROM tbl_projects JOIN tbl_field ON tbl_projects.field_id = tbl_field.id JOIN tbl_sectors ON tbl_projects.sector_id = tbl_sectors.sector_id JOIN tbl_project_type ON tbl_projects.type_id = tbl_project_type.type_id JOIN tbl_agencies ON tbl_projects.agency_id = tbl_agencies.agency_id LEFT JOIN tbl_researchers ON tbl_projects.project_id = tbl_researchers.project_id LEFT JOIN tbl_awards ON tbl_projects.project_id = tbl_awards.project_id ORDER BY tbl_projects.title ASC";    
    
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

<!-- tbl_researchers.researcher_role AS role, tbl_researchers.bachelor_degree, tbl_researchers.bachelor_university, tbl_researchers.master_degree, tbl_researchers.master_university, tbl_researchers.doctorate, tbl_researchers.doctorate_university, tbl_awards.award_name AS award 
JOIN tbl_researchers ON tbl_projects.project_id = tbl_researchers.project_id JOIN tbl_awards ON tbl_projects.project_id = tbl_awards.project_id
-->