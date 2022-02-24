<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/db.php';
include_once '../../models/movie.php';

// Instance database and connect
$db = new db();
$db = $db->connect();

// Instanciate Movie Object
$movie = new movie($db);

// Get query from the URL
$movie->searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : die();

// Movie query
$result = $movie->search();
// get row count
$num = $result->rowCount();

// Check if any movies
if ($num > 0) {
    // movie array
    $movie_arr = array();
    $movie_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $movie_item = array(
            'id' => $id,
            'name' => $name,
            'des' => $des,
            'year' => $year,
            'poster' => $poster,
        );
        // Push to the data
        array_push($movie_arr['data'], $movie_item);
    }

    // Turn it to JSON & output
    echo json_encode($movie_arr);
} else {
    // No movies
    $emptyArray = array();
    $emptyArray['data'] = array();
    echo json_encode(
        $emptyArray
    );
}