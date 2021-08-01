<?php
$quotes = file_get_contents( 'https://joeri-abbo.github.io/marvel-quotes/quotes.json');
$quotes = json_decode($quotes, true);
shuffle($quotes);
header('Content-Type: application/json');

echo json_encode($quotes[key($quotes)]);