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
	 * @method verify
	 * Verifies the id token passed during client login
	 *
	 * @param $id_token ID token of the logged in user
	 * @throws InvalidArgumentException if parameter $id_token is invalid or length is < 1
	 * @return array $token
	 */
	public function verify($id_token) {
		// verify if parameter $id_token meets the expected contract
		if(is_string($id_token) !== true || strlen(trim($id_token)) <1) {
			throw new InvalidArgumentException("Invalid Parameter 'id_token'. Must be a string with length > 0.");
		}

		// verify the id token passed during login
		$token = $this->client->verifyIdToken($id_token);

		//$user = $this->read($token);
		return $token;
	}


}