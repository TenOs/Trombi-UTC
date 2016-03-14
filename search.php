<?php

require_once 'config.php';
header('Content-Type: application/json');


$search = trim(strtolower(clean_string(htmlspecialchars($_GET['name']))));
$names = explode(" ", $search);

$results = array();

foreach ($names as $name) {
    $lastname_results = json_decode(file_get_contents(DIRECTORY_URL . 'nom=' . $name . '&prenom='));
    $firstname_results =  json_decode(file_get_contents(DIRECTORY_URL . 'nom=&prenom=' . $name));
    $results = array_merge($results, $firstname_results, $lastname_results);
}

$final_results = array();

foreach ($results as $r) {

    $fullName = strtolower(clean_string($r->nom));

    $allIncluded = true;

    foreach ($names as $n) {
        if (strpos($fullName, $n) === false)
            $allIncluded = false;
    }

    if ($allIncluded) {
        if ($r->autorisation == "O")
            $r->photo = PHOTO_URL.$r->login;
        else
            $r->photo = 'images/profile-photo.jpg';
        $final_results[$r->login] = $r;
    }
}

echo json_encode(array_values($final_results));


function clean_string ($var) {
    $unwanted_array = array(
        'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A',
        'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
        'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
        'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
        'Þ'=>'B', 'ß'=>'Ss','à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a',
        'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i',
        'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
        'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y',
        '-'=> '', '_'=> '');
    return strtr( $var, $unwanted_array );
}

