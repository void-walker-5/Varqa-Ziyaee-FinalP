<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');

include_once '../../config/db.php';
include_once '../../models/movie.php';

// Instance database and connect
$db = new db();
$db = $db->connect();

// Instanciate Movie Object
$newMovie = new movie($db);

// Get raw posted data
$data = json_decode((file_get_contents("php://input")));

$newMovie->name = $data->name;
$newMovie->des = $data->des;
$newMovie->year = intval($data->year);
$newMovie->poster = $data->poster;

// Create the post
if (isset($newMovie->name) && isset($newMovie->des) && isset($newMovie->year) && isset($newMovie->poster) && $newMovie->create()) {
    echo json_encode(array('message' => 'There is a New movie!'));
} else {
    echo json_encode(array('message' => 'Error in the new movie.'));
}