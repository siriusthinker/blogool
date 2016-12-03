<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends MY_Controller {

	/**
	 * Index constructor.
	 */
	public function __construct() {
		parent::__construct();

	}

	/**
	 * Loads the default homepage
	 * @return void
	 */
	public function index()
	{
		// renders the homepage view
		$this->render('homepage');
	}
}
