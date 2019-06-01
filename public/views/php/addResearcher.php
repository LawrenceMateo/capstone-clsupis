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

    if( isset($_POST['name']) ){
        
        $pId = $_POST['project_id'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];
        $researcherName = trim($_POST['name']);
        $bachelorDegree = trim($_POST['bachelor_degree']);
        $bachelorGrad = trim($_POST['bachelor_grad']);
        $masterDegree = trim($_POST['master_degree']);
        $masterGrad = trim($_POST['master_grad']);
        $doctorate = trim($_POST['doctorate']);
        $doctorateGrad = trim($_POST['doctorate_grad']);

    //     // INCLUDE SCRIPT FOR VALIDATIONS
        include '../../includes/validate.php';

        $validName = isAlpha($researcherName);
        $validBachDegree = isAlpha($bachelorDegree);
        $validBachGrad = isAlpha($bachelorGrad);
        
        if( $masterDegree === '' && $masterGrad === '' ){
            $masterDegree = '';
            $masterGrad = '';
            $validMasterDegree = true;
            $validMasterGrad = true;
        } else {
            $validMasterDegree = isAlpha($masterDegree);
            $validMasterGrad = isAlpha($masterGrad);
        }

        if( $doctorate === '' && $doctorateGrad === '' ){
            $doctorate = '';
            $doctorateGrad = '';
            $validDoctorate = true;
            $validDoctorateGrad = true;
        } else {
            $validDoctorate = isAlpha($doctorate);
            $validDoctorateGrad = isAlpha($doctorateGrad);
        }


        if( !$validName ||
            !$validBachDegree || 
            !$validBachGrad ||
            !$validMasterDegree || 
            !$validMasterGrad 
    //         !$validDoctorate || 
    //         !$validDoctorateGrad 
            ){
            
            $response["error"] = true;
            $response["data"]["message"] = array();

            if( !$validName )
                array_push( $response["data"]["message"], "Researcher name must contain letters only. " );
            if( !$validBachDegree )
                array_push( $response["data"]["message"], "Bachelor's degree must contain letters only. " );
            if( !$validBachGrad )
                array_push( $response["data"]["message"], "Bachelor's degree university must contain letters only. " );
            if( !$validMasterDegree )
                array_push( $response["data"]["message"], "Masteral must contain letters only. " );
            if( !$validMasterGrad )
                array_push( $response["data"]["message"], "Master's degreee university must contain letters only. " );
            if( !$validDoctorate )
                array_push( $response["data"]["message"], "Doctorate must contain letters only. " );
            if( !$validDoctorateGrad )
                array_push( $response["data"]["message"], "Doctorate university must contain letters only. " );

        } else {
            
            // CONNECT TO DATABASE
            include '../../includes/connect_db.php';

            $check = "SELECT fullname FROM tbl_researchers WHERE fullname = '$researcherName'";
            if( $result = mysqli_query( $conn, $check ) ) {
                $researcherCount = mysqli_num_rows( $result );
    
                if( $researcherCount > 0 ){
                    $response["error"] = true;
                    $response["data"]["message"] = "Researcher already exists.";
                } else {
                    $response["data"]["isValidResearcher"] = true;
                    $sql = "INSERT INTO tbl_researchers (project_id, fullname, researcher_role, gender, bachelor_degree, bachelor_university, master_degree, master_university, doctorate, doctorate_university) VALUES ($pId, '$researcherName', '$role', '$gender', '$bachelorDegree', '$bachelorGrad', '$masterDegree', '$masterGrad', '$doctorate', '$doctorateGrad')";
            
                    if(mysqli_query($conn, $sql)){
                    
                        $response["data"]["message"] = "Researcher added successfully. "; 
                    
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