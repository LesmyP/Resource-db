<?php

// check connection - $link 
require_once "_include/resources_db_connect.php";

//  setting arrays
$results = [];
$insertedRows = 0;
// INSERT INTO `lcpr_resourcesdb` (`resourceID`, `resourceName`, `resourceLink`, `resourceType`, `resourceDescription`, `resourceKeyword`, `searchKeyword`, `timestamp`) VALUES (NULL, 'demo item', 'www.demo.com', 'demo', 'demo to take the json file', 'demo', '', current_timestamp());

// prepare a query statement
$query = "INSERT INTO lcpr_resourcesdb (resourceName, resourceLink, resourceType, resourceDescription, resourceKeyword) VALUES (?, ?, ?, ?, ?)";

// execute the queary statement
if ($stmt = mysqli_prepare($link, $query)) {
    // bind parameters for markers
    mysqli_stmt_bind_param($stmt, "ssssss", $_REQUEST["resourceName"], $_REQUEST["resourceLink"], $_REQUEST["resourceType"], $_REQUEST["resourceDescription"], $_REQUEST["resourceKeyword"]);
    // execute the queary statement
    mysqli_stmt_execute($stmt);
    $insertedRows = mysqli_stmt_affected_rows($stmt);

    if ($insertedRows > 0) {
        $results[] = [
            "insertedRows" => $insertedRows,
            "resourceId" => $link->insert_id,
            "resourceName" => $_REQUEST["resourceName"],
        ];
    }
    echo json_encode($results);
}

// https://lesmy74.web582.com/dynamic/project3-exercises/3.2-db/app/insert.php?resourceName=Bootstrap&resourceType=CSSLibrary&resourceLink=www.bootstrap.com&resourceType=libraries&resourceDescription=css libraries&resourceKeyword=CSS&searchKeyword=css