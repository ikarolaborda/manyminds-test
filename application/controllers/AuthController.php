<?php
require_once './vendor/autoload.php';
require_once APPPATH . 'libraries/JWT.php';

use \Firebase\JWT\JWT;
class AuthController extends \chriskacerguis\RestServer\RestController
{
	public function __construct() {
		parent::__construct();
		$this->load->model('User');
	}

	public function register_post() {
		$data = json_decode(file_get_contents('php://input'), true);

		if (!$this->validateInput($data, false)) {
			$errors = validation_errors();
			$this->response(array('status' => 'error', 'message' => 'A Validação falhou: '.json_encode($errors)), 400);
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			if ($this->User->check_email($data['email']) == 0) {
				$id = $this->User->create($data);
				$token = JWT::encode(array('user_id' => $id), (string) getenv('JWT_KEY'), 'HS256');
				$this->response(array(
					'status' => 'success',
					'message' => 'Usuario criado com sucesso.',
					'data' => array(
						'id' => $id,
						'token' => $token
					)), 200);
			}else {
				$this->response(array('status' => 'error', 'message' => 'Email já existe.'), 400);
			}

		}
	}

	public function login_post() {
		$data = json_decode(file_get_contents('php://input'), true);
		if(!$this->validateInput($data, true)) {
			$errors = validation_errors();
			$this->response(array('status' => 'error', 'message' => 'A Validação falhou: '.json_encode($errors)), 400);
		} else {
			$user_id = $this->User->login($data['email'], $data['password']);
			if ($user_id) {
				$token = JWT::encode(array('user_id' => $user_id), (string)getenv('JWT_KEY'), 'HS256');
				$this->response(array(
					'status' => 1,
					'message' => 'Usuario logado com sucesso',
					'token' => $token
				));
			} else {
				$this->response(array(
					'status' => 0,
					'message' => 'email ou senha invalidos'
				));
			}
		}
	}

	/**
	 * @param $data
	 * @return void
	 */
	private function validateInput($data, $isLogin): bool
	{
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);
		if(!$isLogin) {
			$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
		}
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');



		return $this->form_validation->run();
	}

}
