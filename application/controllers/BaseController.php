<?php

abstract class BaseController extends CI_Controller {
	protected $repository;

	public function __construct(Repository $repository) {
		$this->load->library('form_validation');
		parent::__construct();
		$this->repository = $repository;
	}

	protected function validate(array $data, array $rules): bool {
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		if (!$this->form_validation->run()) {
			return false;
		} else {
			return true;
		}
	}
}
