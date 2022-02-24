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
$movie = new movie($db);

// Get raw posted data
$data = json_decode((file_get_contents("php://input")));

$movie->id = $data->id;
$movie->name = $data->name;
$movie->des = $data->des;
$movie->year = intval($data->year);
$movie->poster = $data->poster;

// Create the post
if (isset($movie->name) && isset($movie->des) && isset($movie->year) && isset($movie->poster) && $movie->edit()) {
    echo json_encode(array('message' => 'The movie has been edited.'));
} else {
    echo json_encode(array('message' => 'Error in edit.'));
}