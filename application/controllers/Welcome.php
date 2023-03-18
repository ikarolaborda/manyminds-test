<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function index()
	{
		$serverdata = array(
			'server_name' => $_SERVER['SERVER_NAME'],
			'server_addr' => $_SERVER['SERVER_ADDR'],
			'server_port' => $_SERVER['SERVER_PORT'],
			'load_time' => $this->benchmark->elapsed_time('code_start', 'code_end')
		);

		return $this->output
			->set_content_type('application/json')
			->set_output(json_encode([
				'status' => 'success',
				'data' => $serverdata
			], JSON_UNESCAPED_UNICODE));
	}
}
