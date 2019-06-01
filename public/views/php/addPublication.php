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

    if( isset($_POST['publisher']) && isset($_POST['isbn']) && isset($_POST['date_published']) ){
        $projectId = $_POST['publication_project_id'];
        $title = $_POST['publication_title'];
        $isbn = $_POST['isbn'];
        $datePublished = $_POST['date_published'];
        $publisher = $_POST['publisher'];

        // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $validIsbn = isIsbn($isbn);
        $validPubisher = isAlpha($publisher);

        if( !$validIsbn || !$validPubisher ){
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( !$validIsbn )
                array_push( $response["data"]["message"], "ISBN must be of format xxx-xxxx-xxxx. " );
            if( !$validPubisher )
                array_push( $response["data"]["message"], "Publisher must contain letters only. " );
        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT ISBN FROM tbl_published_projects WHERE ISBN = '$isbn'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $isbnCount = mysqli_num_rows( $result );
    
                if( $isbnCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "The project is already published.";
                } else {
                    $sql = "INSERT INTO tbl_published_projects (project_id, ISBN, project_title, publisher, date_published) VALUES ($projectId, '$isbn', '$title', '$publisher', '$datePublished')";
                    $sqlUpdateProject = "UPDATE tbl_projects SET is_published = 1 WHERE project_id = '$projectId'";
                    if( mysqli_query($conn, $sql) && mysqli_query($conn, $sqlUpdateProject) ){
                        $response["data"]["message"] = "Publication data added successfully. "; 
                    } else { 
                        $response["error"] = true;
                        $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
                    }
                }
                mysqli_free_result( $result );
            } else {
                $response["error"] = true;
                $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
            }

            // CLOSE DB
            mysqli_close( $conn );
        }
    } else {
        $response["error"] = true;
        $response["data"]["message"] = "All fields are required. ";
    }

    echo json_encode( $response );

?>