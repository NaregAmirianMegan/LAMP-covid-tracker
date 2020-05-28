<?php 

// for each user in the users database
// generate a node and add it to the node list
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'users';
$conn = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
if(!$conn ) {
    die ('Connect failed: '.mysqli_connect_error ());
}

$sql = "SELECT * FROM users;";
$stmt = mysqli_stmt_init ($conn);
if (!mysqli_stmt_prepare ($stmt, $sql)) {
    header ("Location: add_contacts.php?error=sqlerror");
    exit ();
}
mysqli_stmt_execute ($stmt);
$result = mysqli_stmt_get_result ($stmt);

$jsonData = new stdClass ();

$nodes = array ();

while ($row = mysqli_fetch_assoc($result)) {
    $new_node = array();
    $new_node["id"] = strval ($row['uid']);
    $new_node["label"] = "";
    $new_node["x"] = rand (0, 500);
    $new_node["y"] = rand (0, 500);
    $new_node["size"] = 2;
    array_push($nodes, $new_node);
}
$jsonData->nodes = $nodes;
// for each contact in the contacts database 
// generate an edge and add it to the edge list
$dbname = 'contacts';
$conn = mysqli_connect ($dbhost, $dbuser, $dbpass, $dbname);
if(!$conn ) {
    die ('Connect failed: '.mysqli_connect_error ());
}

$sql = "SELECT * FROM contacts;";
$stmt = mysqli_stmt_init ($conn);
if (!mysqli_stmt_prepare ($stmt, $sql)) {
    header ("Location: add_contacts.php?error=sqlerror");
    exit ();
}
mysqli_stmt_execute ($stmt);
$result = mysqli_stmt_get_result ($stmt);

$edges = array ();

$count = 0;
while ($row = mysqli_fetch_assoc($result)) {
    $new_edge = array();
    $new_edge["id"] = strval ($count);
    $new_edge["source"] = strval ($row['from_uid']);
    $new_edge["target"] = strval ($row['to_uid']);
    $new_edge["type"] = "arrow";
    array_push($edges, $new_edge);
    $count = $count + 1;
}
$jsonData->edges = $edges;

$fp = fopen('data.json', 'w');
fwrite($fp, json_encode($jsonData, JSON_PRETTY_PRINT));
fclose($fp);

header ("Refresh: 1; url=view-data.php");
header ("Location: view-data.php");