<?php
if (!defined('BASEPATH')) exit('Access denied!');

/**
 * Class: User_Model
 * User related processes
 */
class User_Model extends CI_Model {

	/**
	 * inherit parent constructor of the CI_Model
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @method authenticate
	 * @return stdClass $result
	 */
	public function authenticate ($data) {
		$client = new Google_Client();
		$client->setClientId(GOOGLE_API_CLIENT_ID);
		$client->setClientSecret(GOOGLE_API_CLIENT_SECRET);

		$token_data = $client->verifyIdToken($data['id_token']);

		return $token_data;
	}
}