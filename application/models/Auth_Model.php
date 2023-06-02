<?php
if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

use Firebase\JWT\JWT;

class Auth_Model extends CI_Model
{

	public function login($username, $password)
	{

		$secret_key = 'song_ve_dem';


		$user = $this->db->select('password,id')->from('users')->where('username', $username)->get()->row();
		if ($user == "") {
			return [
				'status' => false,
				'token' => null,
			];
		} else {

			$hashed_password = $user->password;
			$algorithm = 'HS256';
			$user_id = $user->id;

			$payload = array(
				'user_name' => $username,
				'username' => $password
			);
			$expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));

			if (password_verify($password, $hashed_password)) {

				$jwt = JWT::encode($payload, base64_encode($secret_key), $algorithm);

				$last_login = date('Y-m-d H:i:s');
				$this->db->where('id', $user_id)->update('users', array('last_login' => $last_login));
				$this->db->insert('users_authentication', array('users_id' => $user_id, 'token' => $jwt, 'expired_at' => $expired_at));

				return [
					'status' => true,
					'token' => $jwt,
				];
			} else {
				return [
					'status' => false,
					'token' => null,
				];
			}
		}
	}

	public function auth($token)
	{
		$user = $this->db->select('expired_at')->from('users_authentication')->where('token', $token)->get()->row();
		if ($user == "") {
			return [
				'status' => 401,
				'message' => 'Unauthorized',
			];
		} else {
			if ($user->expired_at < date('Y-m-d H:i:s')) {
				$this->json_output(401, array('status' => 401, 'message' => '.'));
				return [
					'status' => 401,
					'message' => 'Your token has been expired!',
				];
			} else {
				$updated_at = date('Y-m-d H:i:s');
				$expired_at = date("Y-m-d H:i:s", strtotime('+12 hours'));
				$this->db->where('token', $token)->update('users_authentication', array('expired_at' => $expired_at, 'updated_at' => $updated_at));
				return [
					'status' => 401,
					'message' => 'Your token has been expired!',
				];
			}
		}
	}

}
