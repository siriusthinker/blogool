<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Class
 */
class Posts extends MY_Controller {

	/**
	 * Posts constructor
	 */
	public function __construct() {
		parent::__construct();

		// load required models
		$this->load->model('Post_Model', 'post_model');
	}

	/**
	 * Displays list of posts
	 *
	 * @return void
	 */
	public function index() {

		$data = array();
		$data['error'] = FALSE;

		try {

			// get the posted page number
			$page = $this->input->post('page');

			// get the id of the logged in user
			$user = $this->session->user_session;

			// construct read data to be passed
			// when calling read_list method
			$read_data = array(
				'user_id' => (int)$user->id
			);

			// call method to get the list of posts
			$response = $this->post_model->read_by_user($read_data);

			// add is_published flag
			foreach($response as $post) {
				$post->is_published = ($post->status === "Published") ? true:false;
			}

			// store list of user data
			$data['posts'] = $response;

			$data['status'] = 200;
		} catch (Exception $e) {
			error_log($e->getMessage());

			$data['error'] = TRUE;
			$data['error_message'] = $e->getMessage();
		}

		echo json_encode($data);
		exit;
	}

	/**
	 * delete
	 * Endpoint to delete post data
	 *
	 * @return void
	 */
	public function delete() {
		// initialize empty array
		$data = array();
		$data['posts'] = array();

		try {
			// set the submitted post id
			$post_id = $this->input->post("post_id");

			// get the id of the logged in user
			$user = $this->session->user_session;

			$result = $this->post_model->delete((int)$post_id, (int)$user->id);

			// fetch the updated list
			if($result === true){
				// construct read data to be passed
				// when calling read_list method
				$read_data = array(
					'user_id' => (int)$user->id
				);

				// call method to get the list of posts
				$response = $this->post_model->read_by_user($read_data);

				// add is_published flag
				foreach($response as $post) {
					$post->is_published = ($post->status === "Published") ? true:false;
				}

				// store list of user data
				$data['posts'] = $response;
			}

			$data['status'] = 200;
		} catch (Exception $e) {
			error_log($e->getMessage());

			$data['error'] = TRUE;
			$data['error_message'] = $e->getMessage();
		}

		// echo the json encoded data
		echo json_encode($data);
		exit;
	}

	/**
	 * update
	 * Endpoint to update post status
	 *
	 * @return void
	 */
	public function update() {
		// initialize empty array
		$data = array();
		$data['posts'] = array();

		try {
			// set the submitted post id
			$post_id = $this->input->post("post_id");
			$status = $this->input->post("status");

			// get the id of the logged in user
			$user = $this->session->user_session;

			$result = $this->post_model->update((int)$post_id, $status, (int)$user->id);

			// fetch the updated list
			if($result === true){
				// construct read data to be passed
				// when calling read_list method
				$read_data = array(
					'user_id' => (int)$user->id
				);

				// call method to get the list of posts
				$response = $this->post_model->read_by_user($read_data);

				// add is_published flag
				foreach($response as $post) {
					$post->is_published = ($post->status === "Published") ? true:false;
				}

				// store list of user data
				$data['posts'] = $response;
			}

			$data['status'] = 200;
		} catch (Exception $e) {
			error_log($e->getMessage());

			$data['error'] = TRUE;
			$data['error_message'] = $e->getMessage();
		}

		// echo the json encoded data
		echo json_encode($data);
		exit;
	}

	/**
	 * update
	 * Endpoint to update post status
	 *
	 * @return void
	 */
	public function create() {
		// initialize empty array
		$data = array();
		$data['posts'] = array();

		try {
			// set the submitted content
			$content = $this->input->post("content");

			// get the id of the logged in user
			$user = $this->session->user_session;

			$result = $this->post_model->create($content, (int)$user->id);

			// fetch the updated list
			if($result > 0){
				// construct read data to be passed
				// when calling read_list method
				$read_data = array(
					'user_id' => (int)$user->id
				);

				// call method to get the list of posts
				$response = $this->post_model->read_by_user($read_data);

				// add is_published flag
				foreach($response as $post) {
					$post->is_published = ($post->status === "Published") ? true:false;
				}

				// store list of user data
				$data['posts'] = $response;
			}

			$data['status'] = 200;
		} catch (Exception $e) {
			error_log($e->getMessage());

			$data['error'] = TRUE;
			$data['error_message'] = $e->getMessage();
		}

		// echo the json encoded data
		echo json_encode($data);
		exit;
	}
}