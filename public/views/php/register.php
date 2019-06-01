<?php

    // SET HEADERS
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');
    header('Cache-Control: no-cache');

    // INIT RESPONSE OBJECT
    $response = array(
        "error" => false,
        "data" => array(
            "message" => ""
        )
    );

    if( isset($_POST['reg_firstname']) && 
        isset($_POST['reg_middlename']) && 
        isset($_POST['reg_lastname']) && 
        isset($_POST['reg_gender']) && 
        isset($_POST['reg_contact_num']) && 
        isset($_POST['reg_email']) && 
        isset($_POST['reg_username']) && 
        isset($_POST['reg_password']) && 
        isset($_POST['reg_con_password']) 
        ){
            
            $firstname =  trim($_POST['reg_firstname']);
            $middlename =  trim($_POST['reg_middlename']);
            $lastname =  trim($_POST['reg_lastname']);
            $gender = $_POST['reg_gender'];
            $contactNumber =  trim($_POST['reg_contact_num']);
            $email =  trim($_POST['reg_email']);
            $username =  trim($_POST['reg_username']);
            $password =  trim($_POST['reg_con_password']);
            $fullname = $firstname.' '.$middlename.' '.$lastname;
            
            // INCLUDE SCRIPT FOR VALIDATIONS
            include '../../includes/validate.php';

            $validFirstname = isAlpha($firstname);
            $validMiddlename = isAlpha($middlename);
            $validLastname = isAlpha($lastname);
            $validContactNum = isNumeric($contactNumber);
            $validEmail = isEmail($email);
            $validUsername = isAlphaNumeric($username);
            $validPassword = isAlphaNumeric($password);
            
            if(

                !$validFirstname ||
                !$validMiddlename ||
                !$validLastname ||
                !$validContactNum ||
                !$validEmail ||
                !$validUsername ||
                !$validPassword 

            ){
                
                $response["error"] = true;
                $response["data"]["message"] = array();

                if( ! $validFirstname )
                array_push( $response["data"]["message"], "Name must contain letters only. " );
                if( ! $validMiddlename )
                array_push( $response["data"]["message"], "Name must contain letters only. " );
                if( ! $validLastname )
                array_push( $response["data"]["message"], "Name must contain letters only. " );
                if( ! $validEmail )
                    array_push( $response["data"]["message"], "Email must be a valid email. " );
                if( ! $validContactNum )
                    array_push( $response["data"]["message"], "Phone Number must contain numbers only. " );
                if( ! $validUsername )
                    array_push( $response["data"]["message"], "Username must contain letters and numbers only. " );
                if( ! $validPassword )
                    array_push( $response["data"]["message"], "Password must contain letters and numbers only. " );

            } else {

                // CONNECT TO DATABASE
                include '../../includes/connect_db.php';

                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $sql = "INSERT INTO tbl_users (firstname, middlename, lastname, gender, email, contact_number, username, password, usertype)
                        VALUES ('$firstname', '$middlename', '$lastname', '$gender', '$email', '$contactNumber', '$username', '$hashedPassword', 'researcher')";

                if(mysqli_query($conn, $sql)){
                    
                    $response["error"] = false;
                    $response["data"]["message"] = "Account is successfully registered. "; 
                
                } else { 

                    $response["error"] = true;
                    $response["data"]["message"] = "Error: " . mysqli_error( $conn ) . ".";
                
                }
                
                // CLOSE DB
                mysqli_close( $conn );
            }
            
    }  else {
        $response["error"] = true;
        $response["data"]["message"] = "All fields are required. ";
    }

    echo json_encode( $response );
?>