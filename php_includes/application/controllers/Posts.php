<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Posts Class
 */
class Posts extends MY_Controller {

	/**
	 * Login constructor
	 */
	public function __construct() {
		parent::__construct();

		// load required models
		$this->load->model('Post_Model', 'post_model');
	}

	/**
	 * Displays list of courses
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

			// calculate the offset of the results from the page number
			// offset should be zero indexed so subtract 1 from page first before multiplying by
			// default page limit
			$offset = (intval($page) - 1) * DEFAULT_PAGE_LIMIT;

			// construct read data to be passed
			// when calling read_list method
			$read_data = array(
				'offset' => $offset,
				'limit' => DEFAULT_PAGE_LIMIT,
				'user_id' => (int)$user->id
			);

			// call method to get the list of courses
			$response = $this->post_model->read_by_user($read_data);

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
}