<?php

class DepartmentController extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Department');
	}

	public function create()
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$this->load->library('form_validation');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules('name', 'Department name', 'required|min_length[3]');

		if (!$this->form_validation->run()) {
			$errors = validation_errors();
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'error', 'message' => 'A validação falhou: '.json_encode($errors))));
		} else {
			$data = json_decode(file_get_contents('php://input'), true);
			$id = $this->Department->create($data);
			return $this
				->output
				->set_content_type('application/json')
				->set_output(
					json_encode(array('status' => 'success', 'message' => 'Departamento criado com sucesso.', 'data' => array('id' => $id))));

		}
	}

	public function read(?int $id = null)
	{
		if ($id) {
			$data = $this->Department->read($id);
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'success', 'data' => $data)));
		} elseif(is_null($id)) {
			$data = $this->Department->getAll();
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'sucesso', 'data' => $data)));
		}else {
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'error', 'message' => 'Departamento não encontrado.')));
		}
	}

	public function update(int $id)
	{
		$data = json_decode(file_get_contents('php://input'), true);
		$success = $this->Department->update($id, $data);
		if ($success) {
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'success', 'message' => 'Departamento atualizado com sucesso.')));
		} else {
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'error', 'message' => 'Departamento não encontrado.')));
		}
	}

	public function delete(int $id)
	{
		$success = $this->Department->delete($id);
		if ($success) {
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'success', 'message' => 'Departamento eliminado com sucesso.')));
		} else {
			return $this
				->output
				->set_content_type('application/json')
				->set_output(json_encode(array('status' => 'error', 'message' => 'Departamento não encontrado.')));
		}
	}

}
