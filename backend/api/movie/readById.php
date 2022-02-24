<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../models/movie.php';

// Instance database and connect
$db = new db();
$db = $db->connect();

// Instantiate Movie Object
$movie = new movie($db);

// Get Id from the URL
$movie->id = isset($_GET['id']) ? $_GET['id'] : die();

// Movie query
$result = $movie->readById();

// create array
$movie_arr = array(
    'id' => $movie->id,
    'name' => $movie->name,
    'des' => $movie->des,
    'year' => $movie->year,
    'poster' => $movie->poster,
);

// Make JSON
print_r(json_encode($movie_arr));
