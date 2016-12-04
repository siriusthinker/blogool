<?php
if (!defined('BASEPATH')) exit('Access denied!');

/**
 * Class: Post_Model
 * Post related processes
 */
class Post_Model extends CI_Model {

	/**
	 * inherit parent constructor of the CI_Model
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @method read_list
	 * Reads list of post based on given query options
	 *
	 * @param array $options - query options
	 * @throws InvalidArgumentException if $options is not an array or is null
	 *
	 * @return array $result
	 */
	public function read_list($options) {
		// verify $options meets expected contract
		if(is_array($options) !== true || count($options) < 1) {
			throw new InvalidArgumentException('Invalid parameter "options" passed. Must be a non-empty array.');
		}

		// verify $options['offset'] meets expected contract
		if(is_int($options['offset']) !== true || $options['offset'] < 0) {
			throw new InvalidArgumentException('Invalid index "offset" passed. Must be an integer with value > 0.');
		}

		// verify $options['limit'] meets expected contract
		if(is_int($options['limit']) !== true || $options['limit'] < 0) {
			throw new InvalidArgumentException('Invalid index "limit" passed. Must be an integer with value > 0.');
		}

		// set limit string
		$limit_str = '';
		if($options['limit'] > 0) {
			$limit_str = "LIMIT {$options['offset']}, {$options['limit']}";
		}

		// set query string
		$sql = "
			SELECT
				" . POSTS . ".*,
				" . POST_STATES . ".`name` AS status,
				CONCAT(''," . USERS . ".first_name,' '," . USERS . ".last_name) as created_by
			FROM
				" . POSTS . "
			INNER JOIN
				" . POST_STATES . " ON " . POST_STATES . ".`id` = " . POSTS . ".`post_state_id`
			INNER JOIN
				" . USERS . " ON " . USERS . ".`id` = " . POSTS . ".`user_id`
			WHERE
				" . POST_STATES . ".`name` = 'Published'
			ORDER BY
				" . POSTS . ".date_created DESC
			{$limit_str}
		";

		// execute query
		$query = $this->db->query($sql);

		// validate if the system is able to run the script
		if (is_object($query) !== TRUE) {
			throw new RuntimeException(EXCEPTION_RUNTIME);
		}

		$result = $query->result();

		// validate if the system is able to get result array
		if (is_array($result) !== TRUE) {
			throw new UnexpectedValueException('Expect a result type of "array" list');
		}

		return $result;
	}

	/**
	 * @method read_by_user
	 * Reads list of post by user
	 *
	 * @param array $options - query options
	 * @throws InvalidArgumentException if $options is not an array or is null
	 *
	 * @return array $result
	 */
	public function read_by_user($options) {
		// verify $options meets expected contract
		if(is_array($options) !== true || count($options) < 1) {
			throw new InvalidArgumentException('Invalid parameter "options" passed. Must be a non-empty array.');
		}

		// verify $options['offset'] meets expected contract
		if(is_int($options['offset']) !== true || $options['offset'] < 0) {
			throw new InvalidArgumentException('Invalid index "offset" passed. Must be an integer with value > 0.');
		}

		// verify $options['limit'] meets expected contract
		if(is_int($options['limit']) !== true || $options['limit'] < 0) {
			throw new InvalidArgumentException('Invalid index "limit" passed. Must be an integer with value > 0.');
		}

		// verify $options['offset'] meets expected contract
		if(is_int($options['user_id']) !== true || $options['user_id'] < 0) {
			throw new InvalidArgumentException('Invalid index "user_id" passed. Must be an integer with value > 0.');
		}

		// set limit string
		$limit_str = '';
		if($options['limit'] > 0) {
			$limit_str = "LIMIT {$options['offset']}, {$options['limit']}";
		}

		// set query string
		$sql = "
			SELECT
				" . POSTS . ".*,
				" . POST_STATES . ".`name` AS status,
				CONCAT(''," . USERS . ".first_name,' '," . USERS . ".last_name) as created_by
			FROM
				" . POSTS . "
			INNER JOIN
				" . POST_STATES . " ON " . POST_STATES . ".`id` = " . POSTS . ".`post_state_id`
			INNER JOIN
				" . USERS . " ON " . USERS . ".`id` = " . POSTS . ".`user_id`
			WHERE
				" . POST_STATES . ".`name` != 'Deleted'
			AND
				" . POSTS . ".`user_id` = " . $this->db->escape($options['user_id']) . "
			ORDER BY
				" . POSTS . ".date_created DESC
		";

		// execute query
		$query = $this->db->query($sql);

		// validate if the system is able to run the script
		if (is_object($query) !== TRUE) {
			throw new RuntimeException(EXCEPTION_RUNTIME);
		}

		$result = $query->result();

		// validate if the system is able to get result array
		if (is_array($result) !== TRUE) {
			throw new UnexpectedValueException('Expect a result type of "array" list');
		}

		return $result;
	}
}