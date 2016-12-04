<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Seeder Class
 *
 * Used for Generating fake random posts
 */
class Seeder extends CI_Controller {
	/**
	 * Seeder constructor
	 */
	public function __construct() {
		parent::__construct();

		// can only be called from the command line
		if (!$this->input->is_cli_request()) {
			exit('Direct access is not allowed');
		}

		// can only be run in the development environment
		if (ENVIRONMENT !== 'development') {
			exit('Can only be run in Development Environment!');
		}

		// this is where we save all our test data
		$this->directory = APPPATH . '../../database/';

		// initialize faker library
		$this->faker = Faker\Factory::create();
	}

	/**
	 * seed local database
	 */
	public function seed()
	{
		// call method to seed fake posts
		$this->_seed_posts(10000);
	}

	/**
	 * seed posts
	 *
	 * @param int $limit
	 * @return void
	 */
	private function _seed_posts($limit) {

		echo "seeding $limit posts";

		$fwrite = fopen($this->directory . 'test_data/posts.sql', 'w+');

		// create a bunch of fake blog posts
		for ($i = 1; $i <= $limit; $i++) {
			echo ".";

			$data = '
				<article>
					<header>
						<h1>' . $this->faker->realText(50, 2) . '</h1>
					</header>
					<p>' . $this->faker->paragraph(3) . '</p>
					<figure>
						<img src="' . $this->faker->imageUrl(640, 480) . '" alt="sample_image">
						<figcaption>' . $this->faker->text(200) . '</figcaption>
					</figure>
					<p>' . $this->faker->paragraph(5) . '</p>
				</article>
			';

			// set random user id
			$user_id = rand(99999, 100099);
			$post_state_id = rand(1, 3);
			$data = $this->db->escape($data);

			// add the post to the file
			$post = "INSERT INTO posts (`id`, `content`, `user_id`, `post_state_id`) VALUES ('{$i}', {$data}, '{$user_id}', '{$post_state_id}');\n";

			// write to file
			fwrite($fwrite, $post);
		}

		echo PHP_EOL;
	}
}