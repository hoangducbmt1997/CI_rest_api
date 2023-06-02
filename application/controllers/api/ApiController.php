<?php



class ApiController extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();

	}
	public function login()
	{

		$method = $_SERVER['REQUEST_METHOD'];

		if ($method != 'POST') {
			echo json_encode(array('status' => 400, 'message' => 'Bad request.'));
		} else {

			$params = $_REQUEST;

			if(empty($params)){
				echo json_encode(array('status' => 400, 'message' => 'Username or password can\'t empty.'));
				return;
			}
			
			$username = $params['username'];
			$password = $params['password'];

			if (empty($username) || empty($password)) {
				echo json_encode(array('status' => 400, 'message' => 'Username or password can\'t empty.'));
				return;
			} else {

				$user = $this->Auth_Model->login($username, $password);

				if ($user['status']) {
					echo json_encode(array('status' => 200, 'token' => $user['token']));
				} else {

					echo json_encode(array('status' => 204, 'message' => 'Wrong username or password.'));
				}
			}
		}

	}

}



?>
