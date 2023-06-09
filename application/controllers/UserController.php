<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class UserController extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('User');
	}

	public function create() {
		$data = json_decode(file_get_contents('php://input'), true);
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

		if (!$this->form_validation->run()) {
			$errors = validation_errors();
			$response = array('status' => 'error', 'message' => 'A Validação falhou: '.json_encode($errors));
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			$data['ip_address'] = $_SERVER['REMOTE_ADDR'];
			$id = $this->User->create($data);
			$response = array('status' => 'success', 'message' => 'Usuario criado com sucesso.', 'data' => array('id' => $id));
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function read(?int $id = null) {
		$data = $this->User->read($id ?? null);
		if ($data) {
			$response = array('status' => 'success', 'data' => $data);
		} else {
			$response = array('status' => 'error', 'message' => 'User not found.');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function update(int $id) {
		$data = json_decode(file_get_contents('php://input'), true);
		$success = $this->User->update($id, $data);
		if ($success) {
			$response = array('status' => 'success', 'message' => 'User updated successfully.');
		} else {
			$response = array('status' => 'error', 'message' => 'Usuario não encontrado.');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}

	public function delete($id) {
		$success = $this->User->delete($id);
		if ($success) {
			$response = array('status' => 'success', 'message' => 'Usuario deletado com sucesso.');
		} else {
			$response = array('status' => 'error', 'message' => 'Usuario não encontrado.');
		}
		$this->output->set_content_type('application/json')->set_output(json_encode($response));
	}
}
