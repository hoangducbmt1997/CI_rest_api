<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BookController extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Book_Model');

	}

	public function index()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'GET') {
			echo json_encode(400, array('status' => 400, 'message' => 'Bad request.'));
		} else {

			$data = $this->Book_Model->book_all_data();
			$res = array(
				'status' => '200',
				'message' => 'Success',
				'data' => $data
			);
			echo json_encode($res);
		}
	}

	public function detail($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'GET' || $this->uri->segment(3) == '' || is_numeric($this->uri->segment(3)) == FALSE) {
			echo json_encode(array('status' => 400, 'message' => 'Bad request.'));
		} else {
			$res = $this->Book_Model->book_detail_data($id);
			echo json_encode($res);
		}
	}

	public function create()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'POST') {
			echo json_encode(array('status' => 400, 'message' => 'Bad request.'));
		} else {

			$title = $this->input->post('title');
			$author = $this->input->post('author');

			if (empty($title) || empty($author)) {
				$resp = array('status' => 400, 'message' => 'Title & Author can\'t empty');
			} else {
				$params = array(
					'title' => $title,
					'author' => $author
				);
				$resp = $this->Book_Model->book_create_data($params);
			}

			echo json_encode($resp);
		}
	}

	public function update($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'PUT') {
			echo json_encode(array('status' => 400, 'message' => 'Bad request.'));
		} else {

			$data = $this->input->input_stream();

			if (!empty($data) && isset($data['title']) && isset($data['author'])) {

				$title = $data['title'];
				$author = $data['author'];

				if (empty($title) || empty($author)) {

					$respStatus = 400;
					$resp = array('status' => 400, 'message' => 'Title & Author can\'t be empty');
				} else {
					$params = array(
						'title' => $title,
						'author' => $author
					);

					$resp = $this->Book_Model->book_update_data($id, $params);
				}
			} else {
				$respStatus = 400;
				$resp = array('status' => 400, 'message' => 'Invalid data format');
			}
			echo json_encode($respStatus, $resp);
		}
	}

	public function delete($id)
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if ($method != 'DELETE') {
			echo json_encode(array('status' => 400, 'message' => 'Bad request.'));
		} else {
			$res = $this->Book_Model->book_delete_data($id);
			echo json_encode($res);
		}
	}
}
