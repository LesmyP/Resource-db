<?php

// helpful information
// Host localhost: 3306
// Database Name:  lesmy_resources
// Database user name: lesmy_resources
// Password: luZf4260!
// Table name: lcpr_resourcesdb
// table columns: resourceID, resourceName, resourceLink, resourceType, resourceDescription, resourceKeyword, timestamp)


$host = "localhost:3306";
$dbname = "lesmy_resources";
$user = "lesmy_resources";
$password = "luZf4260!";

$link = mysqli_connect($host, $user, $password, $dbname);

//create arrays

$db_response = [];
$db_response["success"] = 'not set';

if (!$link) {
    $db_response['success'] = 'false';
} else {
    $db_response['success'] = 'true';
}

// echo toi check connection to db
// echo json_encode($db_response);
