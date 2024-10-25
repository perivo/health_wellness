 
<?php
header('Content-Type: application/json');

$api_url = 'https://api.example.com/diet';
$response = file_get_contents($api_url);
echo $response;
?>
