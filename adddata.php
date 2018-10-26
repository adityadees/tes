<?php
ini_set("display_errors",1);
//database access info
$db = new MySQLi("localhost", "root", "", "polygon_drawer");

$statement = $db->stmt_init();

//database insert statement
$statement->prepare("INSERT INTO public (lat, lon, name, description, category) VALUES (?, ?, ?, ?, ?)");

//grab values from the url and add to database
$statement->bind_param("ddsss", &$_POST['lat'], &$_POST['lon'], &$_POST['name'], &$_POST['description'], &$_POST['category']);
$status = $statement->execute();

//create a status message
if ($status)
{
    $message = array("message" => $_POST['name'] . " has been added!");
}
else
{
    $message = array("error" => $db->error);
}

$statement->close();

echo json_encode($message);
?>