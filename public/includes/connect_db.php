<?php


    $username_db = 'root';
    $password = '';
    $server_name = 'localhost';
    $database_name = 'db_project_information_system';

    $conn = mysqli_connect($server_name, $username_db, $password, $database_name) or die( `Failed to connect to the database. Try again later. ` );

    if( mysqli_connect_errno() ){
        printf( `Connect failed: %s\n`, mysqli_connect_error() );
        exit();
    }

?>