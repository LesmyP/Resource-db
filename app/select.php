<?php
// check connection - $link 
require_once "_include/resources_db_connect.php";

// prepare a query statement
$stmt = mysqli_prepare($link, "SELECT resourceName, resourceLink, resourceType, resourceDescription, resourceKeyword, timestamp FROM lcpr_resourcesdb ORDER BY timestamp DESC");

// execute the queary statement
mysqli_stmt_execute($stmt);

// get the results
$result = mysqli_stmt_get_result($stmt);

// loop through the results
while ($row = mysqli_fetch_assoc($result)) {
    $results[] = $row;
}

// encode & display json
echo json_encode($results);

// close the db link
mysqli_close($link);
