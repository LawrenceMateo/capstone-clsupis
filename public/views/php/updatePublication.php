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
    
    if( isset($_POST['edit_isbn']) && isset($_POST['edit_date_published']) && isset($_POST['edit_publisher']) ){
        
        $publishId = $_POST['edit_publication_id'];
        $isbn = trim($_POST['edit_isbn']);
        $publisher = $_POST['edit_publisher'];
        $datePublished = $_POST['edit_date_published'];
        
        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $validIsbn = isIsbn($isbn);

        if( !$validIsbn ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( !$validIsbn )
                array_push( $response["data"]["message"], "ISBN must haave the format xxx-xxxx-xxxx. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $sql = "UPDATE tbl_published_projects SET ISBN = '$isbn', publisher = '$publisher', date_published = '$datePublished' WHERE publish_id = $publishId";
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