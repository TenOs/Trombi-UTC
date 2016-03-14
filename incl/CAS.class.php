<?php
require_once 'config.php';
require_once 'incl/xmlToArrayParser.class.php';
class CAS
{
	const URL = 'https://cas.utc.fr/cas/';
	public static function authenticate()
	{
		if (!isset($_GET['ticket']) || empty($_GET['ticket'])) return -1;
		$data = file_get_contents(self::URL.'serviceValidate?service='.SITE_URL.'&ticket='.$_GET['ticket']);
		if (empty($data)) return -1;
		$parsed = new xmlToArrayParser($data);
		if (!isset($parsed->array['cas:serviceResponse']['cas:authenticationSuccess']['cas:user'])) return -1;
		return $parsed->array['cas:serviceResponse']['cas:authenticationSuccess']['cas:user'];
	}
	public static function login()
	{
		header('Location: '.self::URL.'login?service='.SITE_URL);
	} 
	public static function logout()
	{
		header('Location: '.self::URL.'logout?service='.SITE_URL);//ou SCRIPT_NAME?
		// On n'utilise pas REQUEST_URI sinon cela d�connecterait � l'infini.
	}
}
