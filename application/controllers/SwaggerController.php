<?php

namespace App\controllers;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="Manyminds Test API", version="1.0.0")
 */

class SwaggerController extends CI_Controller
{
	public function index()
	{
		$this->load->view('swagger_page');
	}
}
