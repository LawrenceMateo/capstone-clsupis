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

    if( isset($_POST['researcher_name']) ){
        $researcher_id = $_POST['researcher_id'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];
        $researcherName = trim($_POST['researcher_name']);
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
            !$validMasterGrad ||
            !$validDoctorate || 
            !$validDoctorateGrad 
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

                    $sql = "UPDATE tbl_researchers SET fullname = '$researcherName', researcher_role = '$role', gender = '$gender', bachelor_degree = '$bachelorDegree', bachelor_university = '$bachelorGrad', master_degree = '$masterDegree', master_university = '$masterGrad', doctorate = '$doctorate', doctorate_university = '$doctorateGrad' WHERE researcher_id = $researcher_id";
            
                    if(mysqli_query($conn, $sql)){
                    
                        $response["data"]["message"] = "Record updated successfully. "; 
                    
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