<?php
defined('BASEPATH') or exit('No direct script access allowed');

use \Firebase\JWT\JWT;

class MY_Controller extends CI_Controller
{
	protected $key = 'songvedem';

	public function __construct()
	{
		parent::__construct();

		// Validate all requests
		$this->authenticate();
	}

	private function authenticate()
	{
		// Get JWT from header or request
		$token = $this->input->get_request_header('Authorization');

		if (!$token) {
			echo json_encode(
				array(
					'status' => 401,
					'error' => 'Unauthorized!'
				)
			);
			exit;
		}

		$algorithm = 'HS256';


		$decoded = JWT::decode($token, $this->key, $algorithm);

		var_dump($decoded);
		die();

		

		try {



			// $user = $this->Auth_Model->auth($username, $password);

		} catch (Exception $e) {
			$this->output
				->set_status_header(401)
				->set_content_type('application/json')
				->set_output(json_encode(['error' => 'Invalid token']));
			exit;
		}
	}
}
