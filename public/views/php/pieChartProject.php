<?php

    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // CONNECT TO DATABASE
    include '../../includes/connect_db.php';

    $sqlSectors = "SELECT * FROM tbl_sectors ORDER BY sector_name ASC";
    $result = mysqli_query($conn, $sqlSectors);
    $sectorCount = mysqli_num_rows($result);

    $response = [];
    if($result){
        $response = array(
            "status" => 200,
            "error" => false,
            "count" => $sectorCount,
            "sectorNames" => array(

            ),
            "sectorCount" => array(

            ),
            "data" => array(
                
            )
        );
        while($row = mysqli_fetch_assoc($result)){
            array_push($response['data'], $row);    
        }

        foreach($response['data'] as $name){
            $names = $name['sector_name'];
            $id = $name['sector_id'];
            $sql = "SELECT COUNT(sector_name) AS sector_count, sector_name, tbl_sectors.sector_id FROM tbl_sectors JOIN tbl_projects ON tbl_projects.sector_id = tbl_sectors.sector_id WHERE tbl_sectors.sector_name = '$names' ORDER BY sector_name ASC";
            $res = mysqli_query($conn, $sql);
            array_push($response['sectorNames'], $names);
            while($sRow = mysqli_fetch_assoc($res)){
                array_push($response['sectorCount'], $sRow);
            }
        }   
    }

    echo json_encode($response);
?>