<?php
    $serverName = "localhost";
    $connectionOptions = array(
        "Database" => "SampleDB",
        "Uid" => "sa",
        "PWD" => ""
    );
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if($conn)
        echo "Connected!"
?>
