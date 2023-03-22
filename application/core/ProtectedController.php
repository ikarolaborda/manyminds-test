<?php

require_once './vendor/autoload.php';
require_once APPPATH . 'libraries/JWT.php';

class Protected_Controller extends \chriskacerguis\RestServer\RestController {
	protected $user_id;

	public function __construct() {
		parent::__construct();
		$jwtHandler = new JwtHandler();

		$headers = $this->input->request_headers();
		$token = explode('Bearer ',$headers['Authorization'])[1] ?? '';
		if (!$token) {
			$this->response(array(
				'status' => 0,
				'message' => 'Token not provided'
			), \chriskacerguis\RestServer\RestController::HTTP_UNAUTHORIZED);
		}

		$decoded = $jwtHandler->decode($token);

		if (!$decoded) {
			$this->response(array(
				'status' => 0,
				'message' => 'Invalid or expired token'
			), \chriskacerguis\RestServer\RestController::HTTP_UNAUTHORIZED);
		}

		$this->user_id = $decoded->user_id;
	}
}
