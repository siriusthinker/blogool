<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Login Class
 */
class Login extends MY_Controller {

	/**
	 * Login constructor
	 */
	public function __construct() {
		parent::__construct();

		// load required models
		$this->load->model('User_Model', 'user_model');

		// load required libraries
		require_once(APPPATH . 'libraries/vendor/autoload.php');
	}

	/**
	 * login
	 * handles the login authentication process
	 *
	 * @return void
	 */
	public function index() {
		$data = array();

		try {

			// call method to authenticate user
			$data["result"] = $this->user_model->authenticate($this->input->post());

			$data['status'] = 200;
		} catch(Exception $e) {
			$data['status'] = 500;
			$data['error_message'] = $e->getMessage();
		}

		echo json_encode($data);
		exit;
	}
}