<?php

require_once './vendor/firebase/php-jwt/src/BeforeValidException.php';
require_once './vendor/firebase/php-jwt/src/ExpiredException.php';
require_once './vendor/firebase/php-jwt/src/SignatureInvalidException.php';
require_once './vendor/firebase/php-jwt/src/JWT.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHandler
{
	protected $jwt_secret;
	protected $token;
	protected $decoded;

	public function __construct() {
		$this->CI =& get_instance();
		$this->jwt_secret = (string) getenv('JWT_KEY');
	}

	public function encode($payload): string
	{
		return JWT::encode($payload, $this->jwt_secret, 'HS256');
	}

	public function decode($token) {
		try {
			$this->decoded = JWT::decode($token, new Key($this->jwt_secret, 'HS256'));
			return $this->decoded;
		} catch (\Exception $e) {
			return false;
		}
	}

}
