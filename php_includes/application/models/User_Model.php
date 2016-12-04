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
	 * @param string $id_token ID token of the logged in user
	 * @throws InvalidArgumentException if parameter $id_token is invalid or length is < 1
	 * @return array $token
	 */
	public function verify($id_token) {
		// verify if parameter $id_token meets the expected contract
		if(is_string($id_token) !== true || strlen(trim($id_token)) < 1) {
			throw new InvalidArgumentException("Invalid Parameter 'id_token'. Must be a string with length > 0.");
		}

		// verify the id token passed during login
		$token = $this->client->verifyIdToken($id_token);

		return $token;
	}

	/**
	 * @method read
	 * Read details of a user
	 *
	 * @param array $user User data from the google client
	 * @throws InvalidArgumentException if parameter $user is invalid
	 * @return array $user_data
	 */
	public function read($user) {
		// verify if parameter $user meets the expected contract
		if(is_array($user) !== true || count($user) < 1) {
			throw new InvalidArgumentException("Invalid Parameter 'user'. Must be a valid array.");
		}

		// set query string
		$sql = "
			SELECT
				" . USERS . ".*
			FROM
				" . USERS . "
			WHERE
				" . USERS . ".`email` = " . $this->db->escape($user['email']) . "
		";

		// execute query
		$query = $this->db->query($sql);

		// validate if the system is able to run the query
		if (is_object($query) !== TRUE) {
			throw new RuntimeException(EXCEPTION_RUNTIME);
		}

		// read user details
		$user_data = $query->row();

		// return user details
		return $user_data;
	}

	/**
	 * @method create
	 * Insert / update user details in the DB
	 *
	 * @param array $data User data from the google client
	 * @throws InvalidArgumentException if parameter $data is invalid
	 * @return int $user_id
	 */
	public function create($data) {
		// verify if parameter $data meets the expected contract
		if(is_array($data) !== true || count($data) < 1) {
			throw new InvalidArgumentException("Invalid Parameter 'data'. Must be a valid array.");
		}

		// set query string
		$sql = "
			INSERT INTO `" . USERS . "`
			(
				`email`,
				`first_name`,
				`last_name`,
				`social_media_id`,
				`profile_image`
			)
			VALUES
			(
				" . $this->db->escape($data['email']) . ",
				" . $this->db->escape($data['given_name']) . ",
				" . $this->db->escape($data['family_name']) . ",
				" . $this->db->escape($data['sub']) . ",
				" . $this->db->escape($data['picture']) . "
			)
		";

		// execute query
		$query = $this->db->query($sql);

		// get the result
		$user = $query->row();

		// return user details
		return $user;
	}

	/**
	 * @method create
	 * Insert / update user details in the DB
	 *
	 * @param array $data User data from the google client
	 * @throws InvalidArgumentException if parameter $data is invalid
	 * @return bool
	 */
	public function update($data) {
		// verify if parameter $data meets the expected contract
		if(is_array($data) !== true || count($data) < 1) {
			throw new InvalidArgumentException("Invalid Parameter 'data'. Must be a valid array.");
		}

		// set query string
		$sql = "
			UPDATE
				`". USERS."`
			SET
				" . USERS . ".`first_name` = " . $this->db->escape($data['given_name']) . ",
				" . USERS . ".`last_name` = " . $this->db->escape($data['family_name']) . ",
				" . USERS . ".`social_media_id` = " . $this->db->escape($data['sub']) . ",
				" . USERS . ".`profile_image` = " . $this->db->escape($data['picture']) . ",
				" . USERS . ".`date_updated` = CURRENT_TIMESTAMP
			WHERE
				" . USERS . ".`email` = " . $this->db->escape($data['email']) . "
		";

		// execute query
		$query = $this->db->query($sql);

		if ($query !== TRUE) {
			throw new RuntimeException('Failed to update user details.');
		}

		return true;
	}
}