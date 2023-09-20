<?php
    $dbHost ='localhost';
    $dbUsername ='root';
    $dbPassword ='';
    $dbName ='foodthai';

    $conn = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

    if($conn->connect_error){
        die("connection failed:".$conn->connect_error);
    }
    echo"";

    


    // header('Content-Type: application/json');

    // try{
    //     $db = new PDO("mysql:host=${dbHost}; db_name=${dbName}", $dbUsername,$dbPassword);
    //     $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //     echo "";
    // }
    // catch(PDOException $se){
    //     echo $se->getMessage();
    // }
    
?>