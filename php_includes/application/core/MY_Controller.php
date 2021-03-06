<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class: MY_Controller
 *
 * @see CI_Controller
 */
class MY_Controller extends CI_Controller {

	/**
	 * @var string $folder
	 */
	public $folder;

	/**
	 * @var Google_Client $client
	 */
	public $client;

	/**
	 * Current User details
	 *
	 * @var string $user
	 */
	protected $user = '';

	/**
	 * Array of templates to be loaded
	 * @var array
	 */
	protected $mustache_templates;

	/**
	 * We will override the Constructor if we need anything on construct
	 *
	 * @return void
	 */
	public function __construct() {

		// we need to call the parent Constructor
		parent::__construct();

		// load models
		//$this->load->model('User_Model', 'user_model');

		// initialize google client
		$this->client = new Google_Client();
		$this->client->setClientId(GOOGLE_API_CLIENT_ID);
		$this->client->setClientSecret(GOOGLE_API_CLIENT_SECRET);

		// default view folder
		$this->folder = 'public';
	}

	/**
	 * Always render the navigation bars
	 *
	 * @param string $view
	 * @param array $vars
	 * @param mixed $return
	 */
	public function render($view = '', $vars = array(), $return = FALSE) {

		// get user session
		$this->user = $this->session->user_session;

		// header variables with the navigation bars
		$header_vars = array(
			'user' => $this->user
		);

		// header
		$this->load->view($this->folder . '/common/header', $header_vars, $return);

		// contents
		$this->load->view($this->folder . '/'. $view, $vars, $return);

		// footer
		$footer_vars = array();

		$this->load->view($this->folder . '/common/footer', $footer_vars, $return);
	}
}

// Acccounts controller
include_once(dirname(__FILE__) . '/MY_Controller_Account.php');