<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	/**
	 * Index constructor.
	 */
	public function __construct() {
		parent::__construct();

		// load required models
		$this->load->model('Post_Model', 'post_model');

		// load required libraries
		$this->load->library('pagination', 'pagination');
	}

	/**
	 * Loads the default homepage
	 * @return void
	 */
	public function index($page = 1) {

		$data = array();
		$data['error'] = FALSE;

		try {
			// calculate the offset of the results from the page number
			// offset should be zero indexed so subtract 1 from page first before multiplying by
			// default page limit
			$offset = (intval($page) - 1) * DEFAULT_PAGE_LIMIT;

			// construct read data to be passed
			// when calling read_list method
			$read_data = array(
				'offset' => $offset,
				'limit' => DEFAULT_PAGE_LIMIT,
			);

			// call method to get the list of courses
			$response = $this->post_model->read_list($read_data);

			// store list of user data
			$data['posts'] = $response;

			// get the total count of users for pagination
			$total_count = 10000;

			// call paginate method
			$data['pagination'] = $this->_paginate(DEFAULT_PAGE_LIMIT, $total_count);

		} catch (Exception $e) {
			error_log($e->getMessage());

			$data['error'] = TRUE;
			$data['error_message'] = $e->getMessage();
		}

		// renders the homepage view
		$this->render("homepage", $data);
	}

	/**
	 * @method paginate
	 * generates the paging links
	 *
	 * @param int limit
	 * @param int $total number of result
	 * @param int $segment
	 *
	 * @return string
	 */
	private function _paginate($limit, $total, $segment = 3) {
		// initialize config
		$config = array();

		// set config values
		$config['base_url'] = base_url('index/index');

		// set totat rows
		$config['total_rows'] = $total;

		// set limit per page
		$config['per_page'] = $limit;

		// set which segement of the url to use as page number
		$config['uri_segment'] = $segment;

		// use correct page numbers (page 1, page 2...)
		$config['use_page_numbers'] = TRUE;

		// query strings must be retained
		$config['reuse_query_string'] = TRUE;

		$config['full_tag_open'] = '<div class="pagination pull-right">';
		$config['full_tag_close'] = '</div>';

		$config['next_link'] = "Next";
		$config['prev_link'] = "Previous";
		$config['display_pages'] = TRUE;

		// initialize pagination
		$this->pagination->initialize($config);

		// generate the paginated links
		return $this->pagination->create_links();
	}

	/**
	 * Loads the default homepage
	 * @return void
	 */
	public function post($page = 1) {

		$data = array();
		$data['error'] = FALSE;

		try {

			$page = $this->input->post('page');

			// calculate the offset of the results from the page number
			// offset should be zero indexed so subtract 1 from page first before multiplying by
			// default page limit
			$offset = (intval($page) - 1) * DEFAULT_PAGE_LIMIT;

			// construct read data to be passed
			// when calling read_list method
			$read_data = array(
				'offset' => $offset,
				'limit' => DEFAULT_PAGE_LIMIT,
			);

			// call method to get the list of courses
			$response = $this->post_model->read_list($read_data);

			// store list of user data
			$data['posts'] = $response;

			// get the total count of users for pagination
			$total_count = 10000;

			// call paginate method
			$data['pagination'] = $this->_paginate(DEFAULT_PAGE_LIMIT, $total_count);

			$data['status'] = 200;
		} catch (Exception $e) {
			error_log($e->getMessage());

			$data['error'] = TRUE;
			$data['error_message'] = $e->getMessage();
		}

		echo json_encode($data);
		exit;

		// renders the homepage view
		//$this->render("homepage", $data);
	}
}
