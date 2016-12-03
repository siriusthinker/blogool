<?php

/**
 * Class: MY_Controller_Account
 *
 * @see MY_Controller
 */
class MY_Controller_Account extends MY_Controller {

	/**
	 * constant role
	 * @var string $role
	 */
	protected $role;

	protected $sub_domain;

	/**
	 * checker if page is organization or not
	 * @var bool
	 */
	protected $is_organization;

	/**
	 * determine if the form is multipage or not
	 * @var true
	 */
	protected $is_multipage;

	/**
	 * sets the page content title
	 * @var string
	 */
	protected $page_content_title;

	/**
	 * determines if we show search widget
	 * @var string
	 */
	protected $has_search_widget;

	/**
	 * sets the modal properties
	 * @var string
	 */
	protected $modal;

	/**
	 * Array of templates to be loaded
	 * @var array
	 */
	protected $mustache_templates;

	/**
	 * __construct()
	 *
	 * We will override the Constructor if we need anything
	 * on construct
	 * @return void
	 */
	public function __construct() {
		// we need to call the parent Constructor
		parent::__construct(false);

		// load libraries
		$this->load->library('API_Client_Transport', array(), 'transport');
		$this->load->library('API_Client', array(), 'client');
		// Load model
		$this->load->model('User_Model', 'user_model');
		$this->load->model('Organization_Model', 'organization_model');

		// Initialize client
		$this->client->init($this->transport, $this->session);

		// default platform
		$this->platform = 'accounts';

		// if view is organization
		$this->is_organization = false;

		// default page content title
		$this->page_content_title = 'Dashboard';

		// sets the default value to show search widget or not
		$this->has_search_widget = false;

		// set default modal properties
		$this->modal = new stdClass();
		$this->modal->title = 'Create';
		$this->modal->type = '';
		$this->modal->action = 'create';
		$this->modal->size = 'medium';
		$this->modal->user_name = '';

		$this->mustache_templates = array();

		// Hostname
		$hostname = $this->input->server('HTTP_HOST');
		$parts = explode('.', $hostname);

		// get the sub domain
		$subdomain = array_shift($parts);

		$this->sub_domain = $subdomain;

		// get the sub domain sessions
		$subdomain_sessions = $this->session->userdata('sub_domains');

		// list the sub domains
		$subdomain_list = array();

		// populate the current sub domain in the session
		if ( is_array($subdomain_sessions) === true && count($subdomain_sessions) > 0 ) {
			foreach ($subdomain_sessions as $key => $item) {
				array_push($subdomain_list, $key);
			}
		}

		// verify if token is present
		// means the user is not logged in
		$token = $this->session->userdata('token');

		// if no parent app token
		if(is_object($token) !== true && $token->data->status !== API_STATUS_CODE_OK) {
			// user is unauthorized, check if ajax request
			if ($this->input->is_ajax_request() === true) {
				// create new object to send as response
				$response = new stdClass;
				$response->status = API_STATUS_CODE_AUTHENTICATION_ERROR;
				$response->error = API_STATUS_MESSAGE_AUTHENTICATION_ERROR;

				// set header content type to json
				$this->output->set_content_type('application/json');
				// set output to the json encoded response object
				$this->output->set_output(json_encode($response));
				// display output and exit
				$this->output->_display();
				exit;
			} else {
				// redirect back to login page
				redirect('/login/logout');
			}
		}

		// perform organization join
		if( in_array($subdomain, $subdomain_list) !== true && $subdomain !== 'accounts' ) {
			$this->_organization_join($subdomain);
		}

 		// but when the user was able to set the token
 		// in the session, determine if the user
 		// role is an business contact or student
 		$user = $this->user_model->read();

 		// @TODO determine the role of the user
// 		if(is_object($user) !== true || isset($user->user->role) !== true || ($user->user->role != GROUP_MANAGER && $user->user->role != GROUP_EMPLOYEE)|| $user->user->status != 'Active') {
// 			redirect('login/logout');
// 		}
	}

	/**
	 * render()
	 *
	 * always render the navigation bars
	 *
	 * @param string $view
	 * @param array $vars
	 * @param mixed $return
	 */
	public function render($view = '', $vars = array(), $return = FALSE) {
		// Get user details for header info
		$user = $this->user_model->read();

		$no_sidebar_page = $this->no_sidebar_page();

		// Header variables
		$header_vars = array(
			'user' => $user->user,
			'no_sidebar_page' => $no_sidebar_page,
			'is_organization' => $this->is_organization,
			'page_content_title' => $this->page_content_title,
			'has_search_widget' => $this->has_search_widget,
			'is_multipage' => $this->is_multipage,
			'modal' => $this->modal
		);

		// header variables with the navigation bars
		$this->load->view($this->platform . '/common/header', $header_vars, $return);

		// contents
		$this->load->view($this->platform . '/'. $view, $vars, $return);

		// if has_search_widget is set to true. show the widget
		if($this->has_search_widget === true) {
			$this->load->view($this->platform . '/common/templates/search_widget', $this->modal, $return);
		}

		// load the mustache templates
		if(is_array($this->mustache_templates) === true && count($this->mustache_templates) > 0) {
			// add my profile templates by default
			array_push($this->mustache_templates, "profile/profile", "profile/add_user");

			// render each templates
			foreach ($this->mustache_templates as $template) {
				$this->load->view($this->platform . '/common/templates/'. $template, $vars, $return);
			}
		}

		// footer
		$this->load->view($this->platform . '/common/footer', array('no_sidebar_page' => $no_sidebar_page), $return);
	}

	/**
	 * Determine if controller is used to display user Profile.
	 * Profile page has different html structure
	 *
	 * @return boolean
	 */
	protected function no_sidebar_page() {

		/*return (
			($this->router->fetch_class() === 'course' && $this->router->fetch_method() === 'lessons') || ($this->router->fetch_class() === 'course' && $this->router->fetch_method() === 'view') || ($this->router->fetch_class() === 'course' && $this->router->fetch_method() === 'lesson')
			|| ($this->router->fetch_class() === 'course' && $this->router->fetch_method() === 'exam') || ($this->router->fetch_class() === 'course' && $this->router->fetch_method() === 'quiz') || ($this->router->fetch_class() === 'course' && $this->router->fetch_method() === 'mycourses_view')
			|| $this->router->fetch_class() === 'preview'
		);*/
	}

	/**
	 * organization_join
	 * joins the organization to the parent organization
	 *
	 * @param string $subdomain
	 * @return void
	 */
	private function _organization_join($subdomain){
		$list = array();

		// get sub domain access token
		try {
			$sub_domain_access = $this->organization_model->read_by_subdomain($subdomain);

			$subdomain_list = $this->session->userdata('sub_domains');

			// if sub domain sessions does not exist
			if(is_array($subdomain_list) === true && count($subdomain_list) < 1) {
				$list = $subdomain_list;
			}

			// prepare the item
			$obj = new stdClass();
			$obj->data = $sub_domain_access;
			$list[$subdomain] = $obj;

			// set the array of sub_domain sessions
			$this->session->set_userdata('sub_domains', $list);

		} catch(Exception $e) {
			if($this->router->fetch_method() !== 'no_permission') {
				$url = $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST'] . '/index/no_permission';
				redirect($url);
			}
		}
	}
}