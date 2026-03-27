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
	}

	/**
	 * handles the login authentication process
	 *
	 * @return void
	 */
	public function index() {
		$data = array();

		try {
			// call method to verify the id token from the client
			$user_details = $this->user_model->verify($this->input->post('id_token'));
			$user_data = $this->user_model->read($user_details);

			// update the data if the user already exist
			// otherwise, save it in our DB
			if(count($user_data) > 0) {
				$data['result'] = $this->user_model->update($user_details);
				$user_session = $user_data;
			} else {
				$data['result'] = $this->user_model->create($user_details);
				$user_session = $data['result'];
			}

			// save the info to the session
			$this->session->set_userdata('user_session', $user_session);

			$data['status'] = 200;
		} catch(Exception $e) {
			$data['status'] = 500;
			$data['error_message'] = $e->getMessage();
		}

		echo json_encode($data);
		exit;
	}

	/**
	 * User Logout
	 */
	public function logout() {

		// remove user session
		$this->session->sess_destroy();

		// redirect to login page
		redirect('/');
	}
}