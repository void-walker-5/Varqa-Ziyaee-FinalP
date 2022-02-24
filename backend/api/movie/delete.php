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
$movie->id = isset($_GET['id']) ? $_GET['id'] : die();

// Movie query
$result = $movie->delete();