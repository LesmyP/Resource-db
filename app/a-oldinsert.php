<?php
/////// try throw catch finally error checking file ////////

header("Content-Type: application/json");
// check connection - $link 
require_once "_include/resources_db_connect.php";

//  setting arrays
$results = [];
$insertedRows = 0;

///// the sql query from phpMyadmin
// INSERT INTO `lcpr_resourcesdb` (`resourceID`, `resourceName`, `resourceLink`, `resourceType`, `resourceDescription`, `resourceKeyword`, `searchKeyword`, `timestamp`) VALUES (NULL, 'demo item', 'www.demo.com', 'demo', 'demo to take the json file', 'demo', '', current_timestamp());

try {
    if (!isset($_REQUEST["resourceName"]) || !isset($_REQUEST["resourceLink"]) || !isset($_REQUEST["resourceType"]) || !isset($_REQUEST["resourceDescription"]) || !isset($_REQUEST["resourceKeyword"])) {
        throw new Exception("Data is missing i.e. resourceLink");
    }

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
                "resourceLink" => $_REQUEST["resourceLink"],
                "resourceType" => $_REQUEST["resourceType"],
                "resourceDescription" => $_REQUEST["resourceDescription"],
                "resourceKeyword" => $_REQUEST["resourceKeyword"],
            ];
        } else {
            throw new Exception("no rows were inserted");
        }
        // echo json_encode($results);
    } else {
        throw new Exception("Prepared statement did not insert records.");
    }
} catch (Exception $error) {
    $results[] = [
        "error" => $error->getMessage(),
    ];
} finally {
    echo json_encode($results);
}


// finally {
//     echo json_encode([
//         "resourceName" => $_REQUEST["resourceName"],
//         "resourceLink" => $_REQUEST["resourceLink"],
//         "resourceType" => $_REQUEST["resourceType"],
//         "resourceDescription" => $_REQUEST["resourceDescription"],
//         "resourceKeyword" => $_REQUEST["resourceKeyword"],
//     ]);





// url with all data inserted https://lesmy74.web582.com/dynamic/project3-exercises/3.2-db/app/insert_2.php?resourceName=LINK&resourceLink=MOM&resourceType=TOM&resourceDescription=POM&resourceKeyword=ROM&searchKeyword=DOM