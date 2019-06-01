<?php

    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';

    $sqlSectors = "SELECT * FROM tbl_field ORDER BY name ASC";
    $result = mysqli_query($conn, $sqlSectors);
    $sectorCount = mysqli_num_rows($result);

    $response = [];
    if($result){
        $response = array(
            "status" => 200,
            "error" => false,
            "count" => $sectorCount,
            "fieldNames" => array(

            ),
            "fieldCount" => array(

            ),
            "data" => array(
                
            )
        );
        while($row = mysqli_fetch_assoc($result)){
            array_push($response['data'], $row);    
        }

        foreach($response['data'] as $name){
            $names = $name['name'];
            $id = $name['id'];
            $sql = "SELECT COUNT(name) AS field_count, name, tbl_field.id FROM tbl_field JOIN tbl_projects ON tbl_projects.field_id = tbl_field.id WHERE tbl_field.name = '$names' ORDER BY name ASC";
            $res = mysqli_query($conn, $sql);
            array_push($response['fieldNames'], $names);
            while($sRow = mysqli_fetch_assoc($res)){
                array_push($response['fieldCount'], $sRow);
            }
        }   
    }

    echo json_encode($response);
?>