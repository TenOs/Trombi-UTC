<?php
session_start();

require_once 'config.php';
require_once 'incl/CAS.class.php';

if (isset($_SESSION['user'])) require_once 'main.php';
else
{
    $user = CAS::authenticate();
    if ($user != -1)
    {
        $_SESSION['user'] = $user;
        $_SESSION['ticket'] = $_GET['ticket'];
        header('Location: ./');
    }
    else CAS::login();
}
?>
