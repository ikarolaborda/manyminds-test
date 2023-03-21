<?php

function getDbConnection(): PDO
{
	$env = parse_ini_file('./.env');

	$db = array(
		'hostname' => $env['DB_HOST'],
		'username' => $env['DB_USERNAME'],
		'password' => $env['DB_PASSWORD'],
		'database' => $env['DB_DATABASE'],
	);
	$dsn = "mysql:host={$db['hostname']};dbname={$db['database']};charset=utf8";
	$options = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false,
	];
	return new PDO($dsn, $db['username'], $db['password'], $options);
}
