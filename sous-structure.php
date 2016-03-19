<?php

require_once 'config.php';
header('Content-Type: application/json');

$result = array();

if (!empty($_GET['struct'])) {
    $result = json_decode(file_get_contents(SOUS_STRUCTURE_API_URL . $_GET['struct']));
}


echo json_encode($result);